<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function status(): JsonResponse
    {
        return response()->json(['message' => 'API is running and Firebird is connected!']);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $row = DB::selectOne(
            'SELECT "USERID", "PASSWORDHASH", "SYSTEMROLE", "ISACTIVE" FROM "USERS" WHERE "EMAIL" = ?',
            [$validated['email']]
        );

        if (!$row) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        if (!$row->ISACTIVE) {
            return response()->json(['error' => 'Account is deactivated'], 403);
        }

        $stored = (string) ($row->PASSWORDHASH ?? '');
        $looksHashed = str_starts_with($stored, '$2y$') || str_starts_with($stored, '$2a$') || str_starts_with($stored, '$argon2');
        $ok = $looksHashed ? Hash::check($validated['password'], $stored) : hash_equals($stored, $validated['password']);

        if (!$ok) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        if (!$looksHashed) {
            DB::update(
                'UPDATE "USERS" SET "PASSWORDHASH" = ? WHERE "USERID" = ?',
                [Hash::make($validated['password']), $row->USERID]
            );
        }

        DB::update('UPDATE "USERS" SET "LASTLOGIN" = CURRENT_TIMESTAMP WHERE "USERID" = ?', [$row->USERID]);

        $role = $row->SYSTEMROLE === 'Admin' ? 'admin' : 'dealer';

        return response()->json([
            'message' => 'Login successful',
            'userID' => $row->USERID,
            'email' => $validated['email'],
            'role' => $role,
        ]);
    }

    public function debugTables(): JsonResponse
    {
        $driver = DB::connection()->getDriverName();
        if ($driver !== 'firebird') {
            return response()->json(['error' => 'debugTables is only implemented for Firebird in this project.'], 400);
        }

        $rows = DB::select(
            'SELECT TRIM(rdb$relation_name) AS name
             FROM rdb$relations
             WHERE rdb$system_flag = 0 AND rdb$view_blr IS NULL
             ORDER BY 1'
        );
        return response()->json(array_map(fn ($r) => ['table' => $r->name], $rows));
    }

    public function debugColumns(string $table): JsonResponse
    {
        $driver = DB::connection()->getDriverName();
        if ($driver !== 'firebird') {
            return response()->json(['error' => 'debugColumns is only implemented for Firebird in this project.'], 400);
        }

        $t = strtoupper(trim($table));
        $rows = DB::select(
            'SELECT
                TRIM(rf.rdb$field_name) AS name,
                f.rdb$field_type AS field_type,
                f.rdb$field_sub_type AS field_sub_type,
                f.rdb$field_length AS field_length,
                f.rdb$field_scale AS field_scale
            FROM rdb$relation_fields rf
            JOIN rdb$fields f ON rf.rdb$field_source = f.rdb$field_name
            WHERE rf.rdb$relation_name = ?
            ORDER BY rf.rdb$field_position',
            [$t]
        );

        return response()->json(array_map(fn ($r) => (array) $r, $rows));
    }

    // ── Leads ──
    public function leadsIndex(): JsonResponse
    {
        $rows = DB::select(
            'SELECT FIRST 200
                "LEADID","PRODUCTID","COMPANYNAME","CONTACTNAME","CONTACTNO","EMAIL","ADDRESS1","ADDRESS2",
                "CITY","POSTCODE","BUSINESSNATURE","USERCOUNT","EXISTINGSOFTWARE","DEMOMODE","DESCRIPTION",
                "REFERRALCODE","CURRENTSTATUS","CREATEDAT","CREATEDBY","ASSIGNED_TO","LASTMODIFIED"
            FROM "LEAD"
            ORDER BY "LEADID" DESC'
        );

        return response()->json(array_map(fn ($r) => (array) $r, $rows));
    }

    public function leadsStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'COMPANYNAME' => 'required|string',
            'CONTACTNAME' => 'nullable|string',
            'CONTACTNO' => 'nullable|string',
            'EMAIL' => 'nullable|string',
            'CITY' => 'nullable|string',
            'CURRENTSTATUS' => 'nullable|string',
            'ASSIGNED_TO' => 'nullable|integer',
        ]);

        $row = DB::selectOne(
            'INSERT INTO "LEAD" ("COMPANYNAME","CONTACTNAME","CONTACTNO","EMAIL","CITY","CURRENTSTATUS","ASSIGNED_TO","CREATEDAT","LASTMODIFIED")
             VALUES (?,?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)
             RETURNING "LEADID","CREATEDAT"',
            [
                $validated['COMPANYNAME'],
                $validated['CONTACTNAME'] ?? null,
                $validated['CONTACTNO'] ?? null,
                $validated['EMAIL'] ?? null,
                $validated['CITY'] ?? null,
                $validated['CURRENTSTATUS'] ?? null,
                $validated['ASSIGNED_TO'] ?? null,
            ]
        );

        return response()->json(['LEADID' => $row->LEADID, 'CREATEDAT' => $row->CREATEDAT], 201);
    }

    // ── Lead Activities ──
    public function leadActivitiesIndex(int $leadId): JsonResponse
    {
        $rows = DB::select(
            'SELECT FIRST 200
                "LEAD_ACTID","LEADID","USERID","CREATIONDATE","SUBJECT","DESCRIPTION","ATTACHMENT","STATUS"
            FROM "LEAD_ACT"
            WHERE "LEADID" = ?
            ORDER BY "LEAD_ACTID" DESC',
            [$leadId]
        );
        return response()->json(array_map(fn ($r) => (array) $r, $rows));
    }

    public function leadActivitiesStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'LEADID' => 'required|integer',
            'USERID' => 'required|integer',
            'SUBJECT' => 'nullable|string',
            'DESCRIPTION' => 'nullable|string',
            'ATTACHMENT' => 'nullable|string',
            'STATUS' => 'nullable|string',
        ]);

        $row = DB::selectOne(
            'INSERT INTO "LEAD_ACT" ("LEADID","USERID","CREATIONDATE","SUBJECT","DESCRIPTION","ATTACHMENT","STATUS")
             VALUES (?,?,CURRENT_TIMESTAMP,?,?,?,?)
             RETURNING "LEAD_ACTID","CREATIONDATE"',
            [
                $validated['LEADID'],
                $validated['USERID'],
                $validated['SUBJECT'] ?? null,
                $validated['DESCRIPTION'] ?? null,
                $validated['ATTACHMENT'] ?? null,
                $validated['STATUS'] ?? null,
            ]
        );

        return response()->json(['LEAD_ACTID' => $row->LEAD_ACTID, 'CREATIONDATE' => $row->CREATIONDATE], 201);
    }

    // ── Referrer Payouts ──
    public function payoutsIndex(): JsonResponse
    {
        $rows = DB::select(
            'SELECT FIRST 200
                "REFERRERPAYOUTID","DEALSUBMISSIONID","USERID","STATUS","REFERRERID","DATEGENERATED","DATEPAID"
            FROM "REFERRER_PAYOUT"
            ORDER BY "REFERRERPAYOUTID" DESC'
        );
        return response()->json(array_map(fn ($r) => (array) $r, $rows));
    }

    // ── Users ──
    public function usersIndex(): JsonResponse
    {
        $rows = DB::select(
            'SELECT "USERID","EMAIL","SYSTEMROLE","ISACTIVE","LASTLOGIN" FROM "USERS" ORDER BY "USERID"'
        );
        return response()->json(array_map(fn ($r) => (array) $r, $rows));
    }
}
