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

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        if ($category == 'SHEQ Officer') {
            return view('dashboard.Officer');
        }
        if ($category == 'SHEQ Guard') {
            $visitorlog = DB::table('visitrecord')
                ->join('users as cont_visit_user', 'visitrecord.contVisitID', '=', 'cont_visit_user.id')
                ->join('users as staff_user', 'visitrecord.staffID', '=', 'staff_user.id')
                ->select('visitrecord.*', 'visitrecord.id as recordID', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                ->where('checkInDate', $today_date)
                ->get();

            return view('dashboard.Guard', compact('visitorlog'));
        }
        if ($category == 'Staff') {
            //dd(Auth::user()->id);
            return view('dashboard.Staff');
        }
        if ($category == 'Contractor') {
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
        if ($category == 'Visitor') {
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
    }
}
