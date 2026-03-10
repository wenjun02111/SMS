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
        $get = function ($row, string $name) {
            if (is_array($row)) {
                foreach ([$name, strtoupper($name), strtolower($name)] as $key) {
                    if (array_key_exists($key, $row)) {
                        return $row[$key];
                    }
                }
                return null;
            }
            foreach ([$name, strtoupper($name), strtolower($name)] as $prop) {
                if (is_object($row) && property_exists($row, $prop)) {
                    return $row->{$prop};
                }
            }
            return null;
        };

        // Lead status summary
        $leadStatusRows = DB::select(
            'SELECT "CURRENTSTATUS" AS status, COUNT(*) AS c FROM "LEAD" GROUP BY "CURRENTSTATUS"'
        );
        $leadStatus = [
            'Open' => 0,
            'Ongoing' => 0,
            'Closed' => 0,
        ];
        foreach ($leadStatusRows as $row) {
            $key = (string) $get($row, 'status');
            if (isset($leadStatus[$key])) {
                $leadStatus[$key] = (int) $get($row, 'c');
            }
        }

        // Unassigned vs assigned leads
        $unassigned = DB::selectOne('SELECT COUNT(*) AS c FROM "LEAD" WHERE "ASSIGNED_TO" IS NULL');

        $pendingActs = DB::select(
            'SELECT "STATUS" AS status, COUNT(*) AS c FROM "LEAD_ACT" GROUP BY "STATUS"'
        );
        $activityStatus = [
            'Pending' => 0,
            'FollowUp' => 0,
            'Demo' => 0,
            'Confirmed' => 0,
            'Completed' => 0,
            'reward' => 0,
        ];
        foreach ($pendingActs as $row) {
            $key = (string) $get($row, 'status');
            if (isset($activityStatus[$key])) {
                $activityStatus[$key] = (int) $get($row, 'c');
            }
        }

        // Last month activity by status (LEAD_ACT has CREATIONDATE)
        $lastMonthActs = DB::select(
            'SELECT "STATUS" AS status, COUNT(*) AS c FROM "LEAD_ACT"
             WHERE EXTRACT(YEAR FROM "CREATIONDATE") = EXTRACT(YEAR FROM DATEADD(MONTH, -1, CURRENT_DATE))
               AND EXTRACT(MONTH FROM "CREATIONDATE") = EXTRACT(MONTH FROM DATEADD(MONTH, -1, CURRENT_DATE))
             GROUP BY "STATUS"'
        );
        $lastMonthActivity = [
            'Pending' => 0,
            'FollowUp' => 0,
            'Demo' => 0,
            'Confirmed' => 0,
            'Completed' => 0,
            'reward' => 0,
        ];
        foreach ($lastMonthActs as $row) {
            $key = (string) $get($row, 'status');
            if (isset($lastMonthActivity[$key])) {
                $lastMonthActivity[$key] = (int) $get($row, 'c');
            }
        }

        // Payout summary
        $payoutRows = DB::select(
            'SELECT "STATUS" AS status, COUNT(*) AS c FROM "REFERRER_PAYOUT" GROUP BY "STATUS"'
        );
        $payoutStatus = [
            'Awaiting Deal Completion' => 0,
            'Pending' => 0,
            'Paid' => 0,
        ];
        foreach ($payoutRows as $row) {
            $key = (string) $get($row, 'status');
            if (isset($payoutStatus[$key])) {
                $payoutStatus[$key] = (int) $get($row, 'c');
            }
        }

        // Last month payout by status
        $lastMonthPayoutRows = DB::select(
            'SELECT "STATUS" AS status, COUNT(*) AS c FROM "REFERRER_PAYOUT"
             WHERE EXTRACT(YEAR FROM "DATEGENERATED") = EXTRACT(YEAR FROM DATEADD(MONTH, -1, CURRENT_DATE))
               AND EXTRACT(MONTH FROM "DATEGENERATED") = EXTRACT(MONTH FROM DATEADD(MONTH, -1, CURRENT_DATE))
             GROUP BY "STATUS"'
        );
        $lastMonthPayout = [
            'Awaiting Deal Completion' => 0,
            'Pending' => 0,
            'Paid' => 0,
        ];
        foreach ($lastMonthPayoutRows as $row) {
            $key = (string) $get($row, 'status');
            if (isset($lastMonthPayout[$key])) {
                $lastMonthPayout[$key] = (int) $get($row, 'c');
            }
        }

        // Inquiry trend for current month (leads created)
        $trendRows = DB::select(
            'SELECT EXTRACT(DAY FROM "CREATEDAT") AS d, COUNT(*) AS c
             FROM "LEAD"
             WHERE EXTRACT(MONTH FROM "CREATEDAT") = EXTRACT(MONTH FROM CURRENT_TIMESTAMP)
               AND EXTRACT(YEAR FROM "CREATEDAT") = EXTRACT(YEAR FROM CURRENT_TIMESTAMP)
             GROUP BY EXTRACT(DAY FROM "CREATEDAT")
             ORDER BY d'
        );
        $inquiryTrend = [];
        $trendByDay = [];
        foreach ($trendRows as $row) {
            $day = (int) $get($row, 'd');
            $count = (int) $get($row, 'c');
            $inquiryTrend[] = ['day' => $day, 'count' => $count];
            $trendByDay[$day] = $count;
        }

        $currentMonthTotal = array_sum($trendByDay);
        $lastMonthRows = DB::select(
            'SELECT COUNT(*) AS c FROM "LEAD"
             WHERE EXTRACT(YEAR FROM "CREATEDAT") = EXTRACT(YEAR FROM DATEADD(MONTH, -1, CURRENT_DATE))
               AND EXTRACT(MONTH FROM "CREATEDAT") = EXTRACT(MONTH FROM DATEADD(MONTH, -1, CURRENT_DATE))'
        );
        $lastMonthTotal = (int) ($lastMonthRows[0]->c ?? 0);
        $inquiryTrendPercentChange = $lastMonthTotal > 0
            ? round(($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal * 100)
            : ($currentMonthTotal > 0 ? 100 : 0);

        // Percent change vs last month for each metric
        $percentChange = function ($current, $lastMonth) {
            if ($lastMonth == 0) {
                return $current > 0 ? 100 : 0;
            }
            return (int) round(($current - $lastMonth) / $lastMonth * 100);
        };
        $metricPercent = [
            'unassigned' => $percentChange($currentMonthTotal, $lastMonthTotal),
            'Pending' => $percentChange($activityStatus['Pending'] ?? 0, $lastMonthActivity['Pending'] ?? 0),
            'FollowUp' => $percentChange($activityStatus['FollowUp'] ?? 0, $lastMonthActivity['FollowUp'] ?? 0),
            'Demo' => $percentChange($activityStatus['Demo'] ?? 0, $lastMonthActivity['Demo'] ?? 0),
            'Confirmed' => $percentChange($activityStatus['Confirmed'] ?? 0, $lastMonthActivity['Confirmed'] ?? 0),
            'Completed' => $percentChange($activityStatus['Completed'] ?? 0, $lastMonthActivity['Completed'] ?? 0),
            'Pending Reward' => $percentChange($payoutStatus['Pending'] ?? 0, $lastMonthPayout['Pending'] ?? 0),
            'Rewarded' => $percentChange($payoutStatus['Paid'] ?? 0, $lastMonthPayout['Paid'] ?? 0),
        ];

        // Product conversion by ProductID
        $productRows = DB::select(
            'SELECT "PRODUCTID" AS product_id, COUNT(*) AS c
             FROM "LEAD"
             WHERE "PRODUCTID" IS NOT NULL
             GROUP BY "PRODUCTID"
             ORDER BY "PRODUCTID"'
        );
        $productLabels = [
            1 => 'SQL Account',
            2 => 'SQL Payroll',
            3 => 'Inventory Pro',
            4 => 'Cloud Sync',
            5 => 'SQL Suite',
        ];
        $productConversion = [];
        foreach ($productRows as $row) {
            $pid = (int) $get($row, 'product_id');
            $productConversion[] = [
                'label' => $productLabels[$pid] ?? 'Product ' . $pid,
                'count' => (int) $get($row, 'c'),
            ];
        }

        return view('admin.reports', [
            'currentPage' => 'reports',
            'leadStatus' => $leadStatus,
            'unassignedLeads' => (int) ($unassigned->c ?? 0),
            'activityStatus' => $activityStatus,
            'payoutStatus' => $payoutStatus,
            'metricPercent' => $metricPercent,
            'inquiryTrend' => $inquiryTrend,
            'inquiryTrendPercentChange' => $inquiryTrendPercentChange,
            'productConversion' => $productConversion,
        ]);
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
