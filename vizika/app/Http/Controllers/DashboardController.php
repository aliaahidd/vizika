<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //FROM LOGIN PAGE TO THIS DASHBOARD PAGE

    public function __construct()
    {
        $this->middleware('auth');
    }

    //authorize session from user type
    public function loadDashboard()
    {
        $category = Auth::user()->category;

        if ($category == 'SHEQ Officer') {
            return redirect()->route('dashboardOfficer');
        }
        if ($category == 'SHEQ Guard') {
            return redirect()->route('dashboardGuard');
        }
        if ($category == 'Staff') {
            return redirect()->route('dashboardStaff');
        }
        if ($category == 'Contractor') {
            return redirect()->route('dashboardContractor');
        }
        if ($category == 'Visitor') {
            return redirect()->route('dashboardVisitor');
        }
    }

    public function visitorDashboard()
    {
        $id = Auth::user()->id;

        //if contractor info exists in the table 
        if (DB::table('visitorinfo')
            ->where('userID', $id)
            ->exists()
        ) {
            return view('dashboard.Visitor');
        } else {
            return redirect()->route('visitordetail');
        }
    }

    public function contractorDashboard()
    {
        $id = Auth::user()->id;

        //if contractor info exists in the table 
        if (DB::table('contractorinfo')
            ->where('userID', $id)
            ->exists()
        ) {
            return view('dashboard.Contractor');
        } else {
            return redirect()->route('contractordetail');
        }
    }

    public function guardDashboard()
    {

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $visitorlog = DB::table('visitrecord')
            ->join('users as cont_visit_user', 'visitrecord.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'visitrecord.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'visitrecord.id as recordID', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('checkInDate', $today_date)
            ->get();

        return view('dashboard.Guard', compact('visitorlog'));
    }

    public function officerDashboard()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        //count total visitor 
        $totalVisitor = DB::table('visitorinfo')->count();
        //count total contractor
        $totalContractor = DB::table('contractorinfo')->count();
        //count total today appointment
        $totalTodayAppointment = DB::table('appointmentinfo')->where('appointmentDate', $today_date)->count();
        //count total record visit
        $totalVisitRecord = DB::table('visitrecord')->count();
        //count for line chart 7 days from today date
        $today = date('Y-m-d');
        $pastDate = date('Y-m-d', strtotime('-7 days'));

        $totalVisitLine = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $count = DB::table('visitrecord')
                ->where('checkInDate', $date)
                ->orderBy('checkInDate', 'asc')
                ->count();
            $totalVisitLine[$date] = $count;
        }

        // Sort the $totalAppointments array by the date keys in ascending order
        ksort($totalVisitLine);

        return view('dashboard.Officer', compact('totalVisitor', 'totalContractor', 'totalTodayAppointment', 'totalVisitRecord', 'totalVisitLine'));
    }

    public function staffDashboard()
    {
        return view('dashboard.Staff');
    }
}
