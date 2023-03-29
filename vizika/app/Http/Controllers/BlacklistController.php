<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BlacklistController extends Controller
{
    //visitor list 
    public function visitor()
    {
        $visitorlist = DB::table('visitorinfo')
            ->orderBy('visitorinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'visitorinfo.visitorID')
            ->where('visitorID', Auth::user()->id)
            ->get();

        return view('appointment.list_appointment', compact('visitorlist'));
    }
}
