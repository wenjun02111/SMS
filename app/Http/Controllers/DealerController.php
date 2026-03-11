<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function dashboard(Request $request): View
    {
        $dealerId = $request->session()->get('user_id');
        $leads = [];
        $metrics = [
            'activeInquiries' => 0,
            'activeInquiriesTrend' => '+12%',
            'conversionRate' => '0%',
            'conversionTrend' => '-2%',
            'closedCaseCount' => 0,
            'demosTrend' => '+5',
            'pendingFollowups' => 0,
        ];
        $emptyWeek = array_map(fn($d) => (object) ['label' => $d, 'count' => 0], ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
        $emptyMonth = array_map(fn($l) => (object) ['label' => $l, 'count' => 0], ['W1', 'W2', 'W3', 'W4', 'W5']);
        $emptyYear = array_map(fn($m) => (object) ['label' => $m, 'count' => 0], ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $closedCaseChartData = ['week' => $emptyWeek, 'month' => $emptyMonth, 'year' => $emptyYear];
        $highPriorityFollowups = [];
        $leadsTotal = 0;
        $inquiriesPage = 1;
        $inquiriesTotalPages = 1;
        $inquiriesPerPage = 6;
        $leadsPaginated = [];

        if ($dealerId) {
            $dealerEmail = trim((string) ($request->session()->get('user_email') ?? ''));
            if (!$dealerEmail) {
                $emailRow = DB::selectOne('SELECT "EMAIL" FROM "USERS" WHERE "USERID" = ?', [$dealerId]);
                $dealerEmail = trim((string) ($emailRow->EMAIL ?? ''));
            }

            $leads = DB::select(
                'SELECT FIRST 50
                    "LEADID","COMPANYNAME","CONTACTNAME","CONTACTNO","EMAIL","CITY","CURRENTSTATUS","CREATEDAT","LASTMODIFIED","DEMOMODE"
                FROM "LEAD"
                WHERE "ASSIGNED_TO" = ?
                ORDER BY "LEADID" DESC',
                [$dealerId]
            );

            $activeCountRow = DB::selectOne(
                'SELECT COUNT(*) AS "CNT" FROM "LEAD"
                WHERE "ASSIGNED_TO" = ? AND UPPER(TRIM(COALESCE("CURRENTSTATUS", \'\'))) = ?',
                [$dealerId, 'ONGOING']
            );
            $activeInquiriesCount = (int) ($activeCountRow->CNT ?? 0);
            $totalAssignedCount = count($leads);

            $closedCountRow = DB::selectOne(
                'SELECT COUNT(*) AS "CNT" FROM "LEAD"
                WHERE "ASSIGNED_TO" = ? AND TRIM(COALESCE("CURRENTSTATUS", \'\')) = ?',
                [$dealerId, 'Closed']
            );
            $closedCount = (int) ($closedCountRow->CNT ?? 0);
            $conversion = $totalAssignedCount > 0 ? round(($closedCount / $totalAssignedCount) * 100, 1) : 0;

            $pendingFollowupsSql = $dealerEmail
                ? 'SELECT COUNT(*) AS "CNT" FROM "LEAD"
                  WHERE "ASSIGNED_TO" = (SELECT "USERID" FROM "USERS" WHERE "EMAIL" = ?)
                  AND UPPER(TRIM(COALESCE("CURRENTSTATUS", \'\'))) = ?'
                : 'SELECT COUNT(*) AS "CNT" FROM "LEAD"
                  WHERE "ASSIGNED_TO" = ? AND UPPER(TRIM(COALESCE("CURRENTSTATUS", \'\'))) = ?';
            $pendingFollowupsParams = $dealerEmail ? [$dealerEmail, 'ONGOING'] : [$dealerId, 'ONGOING'];
            $pendingFollowupsRow = DB::selectOne($pendingFollowupsSql, $pendingFollowupsParams);
            $pendingFollowupsCount = (int) ($pendingFollowupsRow->CNT ?? 0);

            $now = time();
            $weekStart = date('Y-m-d', strtotime('monday this week', $now));
            $weekEnd = date('Y-m-d 23:59:59', strtotime('sunday this week', $now));
            $monthStart = date('Y-m-d', strtotime('first day of this month', $now));
            $monthEnd = date('Y-m-d 23:59:59', strtotime('last day of this month', $now));
            $yearStart = date('Y') . '-01-01';
            $yearEnd = date('Y') . '-12-31 23:59:59';

            $closedRowsWeek = DB::select(
                'SELECT l."LASTMODIFIED" FROM "LEAD" l
                WHERE l."ASSIGNED_TO" = ?
                AND TRIM(COALESCE(l."CURRENTSTATUS", \'\')) = ?
                AND l."LASTMODIFIED" >= CAST(? AS TIMESTAMP) AND l."LASTMODIFIED" <= CAST(? AS TIMESTAMP)',
                [$dealerId, 'Closed', $weekStart, $weekEnd]
            );
            $closedRowsMonth = DB::select(
                'SELECT l."LASTMODIFIED" FROM "LEAD" l
                WHERE l."ASSIGNED_TO" = ?
                AND TRIM(COALESCE(l."CURRENTSTATUS", \'\')) = ?
                AND l."LASTMODIFIED" >= CAST(? AS TIMESTAMP) AND l."LASTMODIFIED" <= CAST(? AS TIMESTAMP)',
                [$dealerId, 'Closed', $monthStart, $monthEnd]
            );
            $closedRowsYear = DB::select(
                'SELECT l."LASTMODIFIED" FROM "LEAD" l
                WHERE l."ASSIGNED_TO" = ?
                AND TRIM(COALESCE(l."CURRENTSTATUS", \'\')) = ?
                AND l."LASTMODIFIED" >= CAST(? AS TIMESTAMP) AND l."LASTMODIFIED" <= CAST(? AS TIMESTAMP)',
                [$dealerId, 'Closed', $yearStart, $yearEnd]
            );

            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $closedByDay = array_fill_keys($days, 0);
            foreach ($closedRowsWeek as $r) {
                $ts = $r->LASTMODIFIED ? strtotime($r->LASTMODIFIED) : $now;
                $dayName = $days[date('N', $ts) - 1];
                $closedByDay[$dayName]++;
            }
            $closedCaseChartWeek = array_map(fn($d) => (object) ['label' => $d, 'count' => $closedByDay[$d]], $days);

            $weekLabels = ['W1', 'W2', 'W3', 'W4', 'W5'];
            $closedByWeek = array_fill_keys($weekLabels, 0);
            foreach ($closedRowsMonth as $r) {
                $ts = $r->LASTMODIFIED ? strtotime($r->LASTMODIFIED) : $now;
                $dayOfMonth = (int) date('j', $ts);
                $weekIdx = min(4, (int) (($dayOfMonth - 1) / 7));
                $closedByWeek[$weekLabels[$weekIdx]]++;
            }
            $closedCaseChartMonth = array_map(fn($l) => (object) ['label' => $l, 'count' => $closedByWeek[$l]], $weekLabels);

            $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $closedByMonth = array_fill_keys($monthLabels, 0);
            foreach ($closedRowsYear as $r) {
                $ts = $r->LASTMODIFIED ? strtotime($r->LASTMODIFIED) : $now;
                $monthName = $monthLabels[(int) date('n', $ts) - 1];
                $closedByMonth[$monthName]++;
            }
            $closedCaseChartYear = array_map(fn($m) => (object) ['label' => $m, 'count' => $closedByMonth[$m]], $monthLabels);

            $closedCaseChartData = [
                'week' => $closedCaseChartWeek,
                'month' => $closedCaseChartMonth,
                'year' => $closedCaseChartYear,
            ];

            $metrics = [
                'activeInquiries' => $activeInquiriesCount,
                'activeInquiriesTrend' => '+12%',
                'conversionRate' => $conversion,
                'conversionTrend' => '-2%',
                'closedCaseCount' => $closedCount,
                'demosTrend' => '+5',
                'pendingFollowups' => $pendingFollowupsCount,
            ];

            $stages = ['PENDING', 'FOLLOW UP', 'DEMO', 'CASE CONFIRMED', 'CASE COMPLETED', 'REWARD DISTRIBUTED'];
            $now = time();
            $highPriorityFollowups = collect($leads)
                ->filter(function ($l) use ($stages) {
                    $status = strtoupper(trim($l->CURRENTSTATUS ?? 'PENDING'));
                    $idx = array_search($status, $stages);
                    $idx = $idx !== false ? $idx : 0;
                    return $idx < 4;
                })
                ->map(function ($l) use ($now, $stages) {
                    $lastMod = $l->LASTMODIFIED ? strtotime($l->LASTMODIFIED) : $now;
                    $nextFollowUp = strtotime('+3 days', $lastMod);
                    $diffSec = $now - $nextFollowUp;

                    if ($diffSec > 0) {
                        $status = 'OVERDUE';
                        $mins = (int) floor($diffSec / 60);
                        $hours = (int) floor($diffSec / 3600);
                        $days = (int) floor($diffSec / 86400);
                        if ($mins < 60) {
                            $time = max(1, $mins) . 'm late';
                        } elseif ($hours < 24) {
                            $time = $hours . 'h late';
                        } else {
                            $time = $days . ' day' . ($days !== 1 ? 's' : '') . ' overdue';
                        }
                    } else {
                        $status = 'DUE SOON';
                        $untilSec = $nextFollowUp - $now;
                        $mins = max(0, (int) floor($untilSec / 60));
                        $hours = max(0, (int) floor($untilSec / 3600));
                        $days = max(0, (int) floor($untilSec / 86400));
                        if ($mins < 60) {
                            $time = 'In ' . max(1, $mins) . 'm';
                        } elseif ($hours < 24) {
                            $time = 'In ' . $hours . 'h';
                        } elseif ($days < 2) {
                            $time = 'In 1 day';
                        } else {
                            $time = 'In ' . $days . ' days';
                        }
                    }

                    $contact = $l->CONTACTNAME ? 'Ms/Mr ' . explode(' ', trim($l->CONTACTNAME))[0] : '—';
                    return (object) [
                        'leadId' => $l->LEADID,
                        'status' => $status,
                        'time' => $time,
                        'inquiryId' => 'LX-' . $l->LEADID,
                        'contact' => $contact,
                        'product' => $l->COMPANYNAME ?: 'SQL Account + Stock',
                        '_sortOrder' => $diffSec,
                    ];
                })
                ->filter(function ($item) {
                    $diffSec = $item->_sortOrder;
                    return $diffSec > 0 || $diffSec >= -172800;
                })
                ->sortBy('_sortOrder', SORT_REGULAR, true)
                ->map(fn($item) => (object) [
                    'leadId' => $item->leadId,
                    'status' => $item->status,
                    'time' => $item->time,
                    'inquiryId' => $item->inquiryId,
                    'contact' => $item->contact,
                    'product' => $item->product,
                ])
                ->values()
                ->all();
        }

        $inquiriesPerPage = 6;
        $leadsTotal = count($leads);
        $inquiriesTotalPages = max(1, (int) ceil($leadsTotal / $inquiriesPerPage));

        return view('dealer.dashboard', [
            'leads' => $leads,
            'leadsTotal' => $leadsTotal,
            'inquiriesTotalPages' => $inquiriesTotalPages,
            'inquiriesPerPage' => $inquiriesPerPage,
            'metrics' => $metrics,
            'closedCaseChartData' => $closedCaseChartData,
            'highPriorityFollowups' => $highPriorityFollowups,
            'currentPage' => 'dashboard',
        ]);
    }

    public function inquiries(Request $request): View
    {
        $dealerId = $request->session()->get('user_id');
        $leads = [];
        if ($dealerId) {
            $leads = DB::select(
                'SELECT FIRST 200
                    l."LEADID", l."PRODUCTID", l."COMPANYNAME", l."CONTACTNAME", l."CONTACTNO", l."EMAIL",
                    l."CITY", l."POSTCODE", l."BUSINESSNATURE", l."USERCOUNT", l."EXISTINGSOFTWARE", l."DEMOMODE",
                    l."DESCRIPTION", l."REFERRALCODE", l."CREATEDAT", l."CREATEDBY",
                    l."ASSIGNED_TO", l."LASTMODIFIED",
                    u."EMAIL" AS "ASSIGNED_BY_EMAIL",
                    COALESCE(
                        (SELECT FIRST 1 la."STATUS" FROM "LEAD_ACT" la WHERE la."LEADID" = l."LEADID" ORDER BY la."CREATIONDATE" DESC),
                        l."CURRENTSTATUS",
                        \'Pending\'
                    ) AS "ACT_STATUS"
                FROM "LEAD" l
                LEFT JOIN "USERS" u ON u."USERID" = l."CREATEDBY"
                WHERE l."ASSIGNED_TO" = ?
                ORDER BY l."LEADID" DESC',
                [$dealerId]
            );
        }
        return view('dealer.inquiries', ['leads' => $leads, 'currentPage' => 'inquiries']);
    }

    public function inquiryActivity(Request $request, int $leadId): JsonResponse
    {
        $dealerId = $request->session()->get('user_id');
        if (!$dealerId) {
            return response()->json(['activities' => []], 200);
        }

        $lead = DB::selectOne('SELECT "LEADID","CREATEDAT","CREATEDBY" FROM "LEAD" WHERE "LEADID" = ? AND "ASSIGNED_TO" = ?', [$leadId, $dealerId]);
        if (!$lead) {
            return response()->json(['activities' => []], 200);
        }

        $activities = [];
        if ($lead->CREATEDAT) {
            $creator = DB::selectOne('SELECT "EMAIL" FROM "USERS" WHERE "USERID" = ?', [$lead->CREATEDBY ?? 0]);
            $activities[] = [
                'type' => 'created',
                'user' => $creator ? trim($creator->EMAIL ?? '') : 'System',
                'subject' => 'Created inquiry',
                'description' => null,
                'status' => null,
                'created_at' => $lead->CREATEDAT,
            ];
        }

        $rows = DB::select(
            'SELECT la."CREATIONDATE", la."SUBJECT", la."DESCRIPTION", la."STATUS", u."EMAIL" AS "USER_EMAIL"
             FROM "LEAD_ACT" la
             LEFT JOIN "USERS" u ON u."USERID" = la."USERID"
             WHERE la."LEADID" = ?
             ORDER BY la."CREATIONDATE" ASC',
            [$leadId]
        );

        foreach ($rows as $r) {
            $activities[] = [
                'type' => 'activity',
                'user' => trim($r->USER_EMAIL ?? 'System'),
                'subject' => trim($r->SUBJECT ?? ''),
                'description' => trim($r->DESCRIPTION ?? ''),
                'status' => trim($r->STATUS ?? ''),
                'created_at' => $r->CREATIONDATE,
            ];
        }

        usort($activities, function ($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });

        return response()->json(['activities' => $activities]);
    }

    public function updateInquiryStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lead_id' => 'required|integer',
            'status' => 'required|string|max:50',
            'remark' => 'nullable|string|max:4000',
        ]);

        $dealerId = $request->session()->get('user_id');
        if (!$dealerId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $leadId = (int) $validated['lead_id'];
        $lead = DB::selectOne('SELECT "LEADID" FROM "LEAD" WHERE "LEADID" = ? AND "ASSIGNED_TO" = ?', [$leadId, $dealerId]);
        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Lead not found or not assigned to you'], 404);
        }

        $status = trim($validated['status']);
        $remark = trim($validated['remark'] ?? '');
        $statusDb = $this->mapStatusToDb($status);

        $lastAct = DB::selectOne(
            'SELECT FIRST 1 la."STATUS" FROM "LEAD_ACT" la WHERE la."LEADID" = ? ORDER BY la."CREATIONDATE" DESC',
            [$leadId]
        );
        $fromStatus = $lastAct ? trim($lastAct->STATUS ?? '') : 'Pending';
        $toStatus = $statusDb;
        $description = $remark !== '' ? $remark : ('Update Status from ' . $fromStatus . ' to ' . $toStatus);

        DB::insert(
            'INSERT INTO "LEAD_ACT" ("LEADID","USERID","CREATIONDATE","SUBJECT","DESCRIPTION","ATTACHMENT","STATUS")
             VALUES (?,?,CURRENT_TIMESTAMP,?,?,?,?)',
            [$leadId, $dealerId, 'Updated Status', $description, null, $statusDb]
        );

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }

    private function mapStatusToDb(string $status): string
    {
        $map = [
            'PENDING' => 'Pending',
            'FOLLOW UP' => 'FollowUp',
            'DEMO' => 'Demo',
            'CONFIRMED' => 'Confirmed',
            'COMPLETED' => 'Completed',
            'REWARDED' => 'Rewarded',
            'REWARD DISTRIBUTED' => 'Rewarded',
            'FAILED' => 'Failed',
        ];
        $upper = strtoupper(trim($status));
        return $map[$upper] ?? $status;
    }

    public function demo(Request $request): View
    {
        $dealerId = $request->session()->get('user_id');
        $leads = [];
        if ($dealerId) {
            $leads = DB::select(
                'SELECT FIRST 100
                    "LEADID","COMPANYNAME","CONTACTNAME","EMAIL","CURRENTSTATUS","DEMOMODE","CREATEDAT","LASTMODIFIED"
                FROM "LEAD"
                WHERE "ASSIGNED_TO" = ?
                ORDER BY "LEADID" DESC',
                [$dealerId]
            );
        }
        return view('dealer.demo', ['leads' => $leads, 'currentPage' => 'demo']);
    }

    public function rewards(Request $request): View
    {
        return view('dealer.rewards', ['currentPage' => 'rewards']);
    }

    public function reports(Request $request): View
    {
        return view('dealer.reports', ['currentPage' => 'reports']);
    }

    public function history(Request $request): View
    {
        $dealerId = $request->session()->get('user_id');
        $activities = [];
        if ($dealerId) {
            $activities = DB::select(
                'SELECT la."LEAD_ACTID", la."LEADID", la."CREATIONDATE", la."SUBJECT", la."DESCRIPTION", la."STATUS"
                FROM "LEAD_ACT" la
                JOIN "LEAD" l ON l."LEADID" = la."LEADID"
                WHERE l."ASSIGNED_TO" = ?
                ORDER BY la."LEAD_ACTID" DESC',
                [$dealerId]
            );
        }
        return view('dealer.history', ['activities' => $activities, 'currentPage' => 'history']);
    }
}
