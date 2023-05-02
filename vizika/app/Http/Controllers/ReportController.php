<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyBriefingInfo;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function report()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $reportlist = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('users as cont_visit_user', 'visitrecord.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'visitrecord.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->get();

        return view('report.list_report', compact('reportlist'));
    }

    public function generatereport(Request $request)
    {
        //request input from form 
        $dateStart = $request->input('dateStart');
        $dateEnd = $request->input('dateEnd');

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $reportlist = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('users as cont_visit_user', 'visitrecord.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'visitrecord.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->whereBetween('checkInDate', [$dateStart, $dateEnd])
            ->get();

        return view('report.list_report', compact('reportlist'));
    }
}
