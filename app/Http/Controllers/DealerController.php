<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DealerController extends Controller
{
    public function dashboard(Request $request): View
    {
        $dealerId = $request->session()->get('user_id');
        $leads = [];
        if ($dealerId) {
            $leads = DB::select(
                'SELECT FIRST 50
                    "LEADID","COMPANYNAME","CONTACTNAME","CONTACTNO","EMAIL","CITY","CURRENTSTATUS","CREATEDAT","LASTMODIFIED"
                FROM "LEAD"
                WHERE "ASSIGNED_TO" = ?
                ORDER BY "LEADID" DESC',
                [$dealerId]
            );
        }
        return view('dealer.dashboard', ['leads' => $leads, 'currentPage' => 'dashboard']);
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
}
