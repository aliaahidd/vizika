<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

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
            return view('dashboard.Officer');
        }
        if ($category == 'SHEQ Guard') {
            return view('dashboard.Guard');
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
