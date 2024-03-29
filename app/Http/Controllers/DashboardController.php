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
        if ($category == 'Company') {
            return redirect()->route('dashboardCompany');
        }
    }

    public function visitorDashboard()
    {
        $id = Auth::user()->id;

        //if contractor info exists in the table 
        if (DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->where('userID', $id)
            ->where('users.status', 'Active')
            ->exists()
        ) {
            // Set the timezone to Kuala Lumpur
            $kl_timezone = 'Asia/Kuala_Lumpur';

            // Get today's date in Kuala Lumpur timezone
            $today_date = Carbon::now($kl_timezone)->toDateString();
            $upcomingDate = Carbon::now($kl_timezone)->addDay();

            //count total today appointment 
            $totalTodayAppt = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->where('contVisitID', $id)->count();
            //count Total Tomorrow Appointment 
            $totalUpcomingAppt = DB::table('appointmentinfo')->whereDate('appointmentDateStart', $upcomingDate)->where('contVisitID', $id)->count();
            //count total past appointment 
            $totalPastAppt = DB::table('visitrecord')
                ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                ->whereNotNull('visitrecord.checkOutDate')->where('contVisitID', $id)->count();

            //today appointment data
            $todayAppointment = DB::table('appointmentinfo')
                ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                ->where('appointmentDateStart', '<=', $today_date) // Check if appointmentDateStart is less than or equal to today's date
                ->where('appointmentDateEnd', '>=', $today_date)   // Check if appointmentDateEnd is greater than or equal to today's date
                ->where('contVisitID', $id)->get();

            return view('dashboard.visitor', compact('totalTodayAppt', 'totalUpcomingAppt', 'totalPastAppt', 'todayAppointment'));
        } elseif (DB::table('users')
            ->where('id', $id)
            ->where('status', 'Pending')
            ->exists()
        ) {
            return redirect()->route('visitordetail');
        } else {
            return redirect()->route('finishform');
        }
    }

    public function contractorDashboard()
    {
        $id = Auth::user()->id;

        //if contractor info exists in the table 
        if (DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->where('userID', $id)
            ->where('users.status', 'Active')
            ->exists()
        ) {
            // Set the timezone to Kuala Lumpur
            $kl_timezone = 'Asia/Kuala_Lumpur';

            // Get today's date in Kuala Lumpur timezone
            $today_date = Carbon::now($kl_timezone)->toDateString();
            $upcomingDate = Carbon::now($kl_timezone)->addDay();

            //count total today appointment 
            $totalTodayAppt = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->where('contVisitID', $id)->count();
            //count Total Tomorrow Appointment 
            $totalUpcomingAppt = DB::table('appointmentinfo')->whereDate('appointmentDateStart', $upcomingDate)->where('contVisitID', $id)->count();
            //count total past appointment 
            $totalPastAppt = DB::table('visitrecord')
                ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                ->whereNotNull('visitrecord.checkOutDate')->where('contVisitID', $id)->count();

            //today appointment data
            $todayAppointment = DB::table('appointmentinfo')
                ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                ->where('appointmentDateStart', '<=', $today_date) // Check if appointmentDateStart is less than or equal to today's date
                ->where('appointmentDateEnd', '>=', $today_date)   // Check if appointmentDateEnd is greater than or equal to today's date
                ->where('contVisitID', $id)->get();

            return view('dashboard.contractor', compact('totalTodayAppt', 'totalUpcomingAppt', 'totalPastAppt', 'todayAppointment'));
        } elseif (DB::table('users')
            ->join('contractorinfo', 'users.id', '=', 'contractorinfo.userID')
            ->where('users.id', $id)
            ->where('status', 'Pending')
            ->exists()
        ) {
            return redirect()->route('finishform');
        } elseif (DB::table('users')
            ->join('contractorinfo', 'users.id', '=', 'contractorinfo.userID')
            ->where('users.id', $id)
            ->where('status', 'Rejected')
            ->exists()
        ) {
            return redirect()->route('bookbriefing');
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

        //count total appointment 
        $totalAppointment = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->count();
        //count total check in 
        $totalCheckIn = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->where('visitrecord.checkOutDate', NULL)->count();
        //count total checkout 
        $totalCheckOut = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->whereNotNull('visitrecord.checkOutDate')->count();

        $visitorlog = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'visitrecord.id as recordID', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'appointmentinfo.*')
            ->where('checkInDate', $today_date)
            ->get();

        return view('dashboard.guard', compact('visitorlog', 'totalAppointment', 'totalCheckIn', 'totalCheckOut'));
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
        //count total staff 
        $totalStaff = DB::table('users')->where('category', '=', 'Staff')->count();
        //count total guard 
        $totalGuard = DB::table('users')->where('category', '=', 'SHEQ Guard')->count();
        //count total officer 
        $totalOfficer = DB::table('users')->where('category', '=', 'SHEQ Officer')->count();
        //count total appointment 
        $totalAppointment = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->count();
        //count total check in 
        $totalCheckIn = DB::table('visitrecord')->where('checkOutDate', NULL)->count();
        //count total checkout 
        $totalCheckOut = DB::table('visitrecord')->whereNotNull('checkOutDate')->count();
        //visitor log
        $visitorlog = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'visitrecord.id as recordID', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('checkInDate', $today_date)
            ->get();

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

        return view('dashboard.officer', compact('totalVisitor', 'totalContractor', 'totalStaff', 'totalGuard', 'totalOfficer', 'totalAppointment', 'totalCheckIn', 'totalCheckOut', 'totalVisitLine', 'visitorlog'));
    }

    public function staffDashboard()
    {
        $id = Auth::user()->id;

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $upcomingDate = Carbon::now($kl_timezone)->addDay();

        //count total today appointment 
        $totalTodayAppt = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->where('staffID', $id)->count();
        //count Total Tomorrow Appointment 
        $totalUpcomingAppt = DB::table('appointmentinfo')->whereDate('appointmentDateStart', $upcomingDate)->where('staffID', $id)->groupBy('appointmentDateStart')->distinct()->count();
        //count total past appointment 
        $totalPastAppt = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->whereNotNull('visitrecord.checkOutDate')->where('staffID', $id)->count();

        //today appointment data
        $todayAppointment = DB::table('appointmentinfo')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('appointmentDateStart', '<=', $today_date) // Check if appointmentDateStart is less than or equal to today's date
            ->where('appointmentDateEnd', '>=', $today_date)   // Check if appointmentDateEnd is greater than or equal to today's date
            ->where('staffID', $id)->get();

        //count total visitor 
        $totalVisitor = DB::table('visitorinfo')->count();
        //count total contractor 
        $totalContractor = DB::table('contractorinfo')->count();

        //count for line chart 7 days from today date
        $today = date('Y-m-d');
        $pastDate = date('Y-m-d', strtotime('-7 days'));

        $totalVisitLine = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $count = DB::table('visitrecord')
                ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                ->where('visitrecord.checkInDate', $date)
                ->where('appointmentinfo.staffID', $id)
                ->orderBy('visitrecord.checkInDate', 'asc')
                ->count();
            $totalVisitLine[$date] = $count;
        }

        // Sort the $totalAppointments array by the date keys in ascending order
        ksort($totalVisitLine);

        return view('dashboard.staff', compact('totalTodayAppt', 'totalUpcomingAppt', 'totalPastAppt', 'todayAppointment', 'totalVisitor', 'totalContractor', 'totalVisitLine'));
    }

    public function companyDashboard()
    {
        $id = Auth::user()->id;

        //if contractor info exists in the table 
        if (DB::table('users')
            ->where('id', $id)
            ->where('status', 'Active')
            ->exists()
        ) {
            // Set the timezone to Kuala Lumpur
            $kl_timezone = 'Asia/Kuala_Lumpur';

            // Get today's date in Kuala Lumpur timezone
            $today_date = Carbon::now($kl_timezone)->toDateString();
            $upcomingDate = Carbon::now($kl_timezone)->addDay();

            //count total today appointment 
            $totalTodayAppt = DB::table('appointmentinfo')->where('appointmentDateStart', '<=', $today_date)->where('appointmentDateEnd', '>=', $today_date)->where('contVisitID', $id)->count();
            //count Total Tomorrow Appointment 
            $totalUpcomingAppt = DB::table('appointmentinfo')->whereDate('appointmentDateStart', $upcomingDate)->where('contVisitID', $id)->count();
            //count total past appointment 
            $totalPastAppt = DB::table('visitrecord')
                ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                ->whereNotNull('visitrecord.checkOutDate')->where('contVisitID', $id)->count();

            //today appointment data
            $todayAppointment = DB::table('appointmentinfo')
                ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                ->where('appointmentDateStart', '<=', $today_date) // Check if appointmentDateStart is less than or equal to today's date
                ->where('appointmentDateEnd', '>=', $today_date)   // Check if appointmentDateEnd is greater than or equal to today's date
                ->where('contVisitID', $id)->get();

            return view('dashboard.contractor', compact('totalTodayAppt', 'totalUpcomingAppt', 'totalPastAppt', 'todayAppointment'));
        } elseif (DB::table('users')
            ->where('id', $id)
            ->where('status', 'Pending')
            ->exists()
        ) {
            return redirect()->route('companydetail');
        } else {
            return redirect()->route('finishform');
        }
    }
}
