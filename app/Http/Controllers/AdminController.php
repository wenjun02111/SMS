<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    private function dashboardData(): array
    {
        $leads = DB::select('SELECT COUNT(*) as c FROM "LEAD"');
        $activities = DB::select('SELECT COUNT(*) as c FROM "LEAD_ACT"');
        $payouts = DB::select('SELECT COUNT(*) as c FROM "REFERRER_PAYOUT"');
        $users = DB::select('SELECT COUNT(*) as c FROM "USERS"');
        return [
            'totalLeads' => $leads[0]->c ?? 0,
            'totalActivities' => $activities[0]->c ?? 0,
            'totalPayouts' => $payouts[0]->c ?? 0,
            'totalUsers' => $users[0]->c ?? 0,
        ];
    }

    public function dashboard(): View
    {
        return view('admin.dashboard', array_merge($this->dashboardData(), ['currentPage' => 'dashboard']));
    }

    public function inquiries(): View
    {
        $rows = DB::select(
            'SELECT FIRST 100
                "LEADID","PRODUCTID","COMPANYNAME","CONTACTNAME","CONTACTNO","EMAIL","CITY","POSTCODE",
                "BUSINESSNATURE","USERCOUNT","EXISTINGSOFTWARE","DEMOMODE","CURRENTSTATUS",
                "CREATEDAT","CREATEDBY","ASSIGNED_TO","LASTMODIFIED"
            FROM "LEAD"
            ORDER BY "LEADID" DESC'
        );
        return view('admin.inquiries', ['items' => $rows, 'currentPage' => 'inquiries']);
    }

    public function dealers(): View
    {
        $rows = DB::select(
            'SELECT "USERID","EMAIL","SYSTEMROLE","ISACTIVE","LASTLOGIN"
             FROM "USERS"
             ORDER BY "USERID"'
        );
        return view('admin.dealers', ['items' => $rows, 'currentPage' => 'dealers']);
    }

    public function rewards(): View
    {
        $rows = DB::select(
            'SELECT FIRST 100
                "REFERRERPAYOUTID","DEALSUBMISSIONID","USERID","REFERRERID","STATUS","DATEGENERATED","DATEPAID"
            FROM "REFERRER_PAYOUT"
            ORDER BY "REFERRERPAYOUTID" DESC'
        );
        return view('admin.rewards', ['items' => $rows, 'currentPage' => 'rewards']);
    }

    public function reports(): View
    {
        return view('admin.reports', ['currentPage' => 'reports']);
    }

    public function history(): View
    {
        $rows = DB::select(
            'SELECT FIRST 100
                "LEAD_ACTID","LEADID","USERID","CREATIONDATE","SUBJECT","DESCRIPTION","ATTACHMENT","STATUS"
            FROM "LEAD_ACT"
            ORDER BY "LEAD_ACTID" DESC'
        );
        return view('admin.history', ['items' => $rows, 'currentPage' => 'history']);
    }

    public function fulldatabase(): View
    {
        $tables = [
            'lead' => DB::select('SELECT FIRST 200 * FROM "LEAD" ORDER BY "LEADID" DESC'),
            'lead_act' => DB::select('SELECT FIRST 200 * FROM "LEAD_ACT" ORDER BY "LEAD_ACTID" DESC'),
            'referrer_payout' => DB::select('SELECT FIRST 200 * FROM "REFERRER_PAYOUT" ORDER BY "REFERRERPAYOUTID" DESC'),
            'users' => DB::select('SELECT FIRST 200 * FROM "USERS" ORDER BY "USERID" DESC'),
            'user_passkey' => DB::select('SELECT FIRST 200 * FROM "USER_PASSKEY" ORDER BY "USER_PASSKEYID" DESC'),
        ];
        return view('admin.fulldatabase', ['tables' => $tables, 'currentPage' => 'fulldatabase']);
    }
}
