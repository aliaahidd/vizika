<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function storecontractorinfo(Request $request)
    {
        // get user auth
        $id = Auth::user()->id;
        $phonenumber = $request->input('phoneNo');
        $companyname = $request->input('companyName');
        $expiryDate = $request->input('validityPass');
        $purpose = $request->input('purpose');

        $data = array(
            'userID' => $id,
            'phoneNo' => $phonenumber,
            'company' => $companyname,
            'passExpiryDate' => $expiryDate,
            'purpose' => $purpose,
        );

        // insert query
        DB::table('contractorinfo')->insert($data);

        return view('dashboard.Contractor');
    }

    public function storevisitorinfo(Request $request)
    {
        // get user auth
        $id = Auth::user()->id;
        $employeeID = $request->input('employeeID');
        $companyname = $request->input('companyName');
        $occupation = $request->input('occupation');
        $phonenumber = $request->input('phoneNo');

        $data = array(
            'userID' => $id,
            'employeeID' => $employeeID,
            'company' => $companyname,
            'occupation' => $occupation,
            'phoneNo' => $phonenumber,
        );

        // insert query
        DB::table('visitorinfo')->insert($data);

        return view('dashboard.Visitor');
    }

    public function visitor(Request $request)
    {
        $visitorlist = DB::table('visitorinfo')
            ->orderBy('visitorinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->get();

        return view('blacklist.list_visitor', compact('visitorlist'));
    }
}
