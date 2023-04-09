<?php

namespace App\Http\Controllers;

use App\Models\ContractorInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function loadProfile($id)
    {
        $id = Auth::user()->id;

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->where('users.id', $id)
            ->first();

        return view('profile.profile', compact('contractor', 'visitor'));
    }

    public function editprofile($id)
    {
        $id = Auth::user()->id;

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->select([
                'users.id AS sessionID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->select([
                'users.id AS sessionID',
                'visitorinfo.id AS visitID', 'users.*', 'visitorinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        return view('profile.edit_profile', compact('contractor', 'visitor'));
    }

    public function updateprofile(Request $request, $id)
    {
        // find the id from contractorinfo

        $contractorinfo = ContractorInfo::find($id);

        if ($request->hasFile('passportPhoto')) {
            //unlink the old contractorinfo file from assets folder
            $path = public_path() . '/assets/' . $contractorinfo->passportPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $contractorinfo->passportPhoto = $request->file('passportPhoto');

            //to rename the contractorinfo file
            $filename = time() . '.' . $contractorinfo->passportPhoto->getClientOriginalExtension();
            // to store the new file by moving to assets folder
            $request->passportPhoto->move('assets', $filename);

            $contractorinfo->passportPhoto = $filename;
        }

        $contractorinfo->companyName = $request->input('companyName');
        $contractorinfo->phoneNo = $request->input('phoneNo');
        $contractorinfo->passExpiryDate = $request->input('passExpiryDate');
        $contractorinfo->birthDate = $request->input('birthDate');
        $contractorinfo->address = $request->input('address');

        // upadate query in the database
        $contractorinfo->update();

        // display message box in the same page
        return redirect()->back()->with('message', 'Contractor Info Updated Successfully');
    }

    public function storecontractorinfo(Request $request)
    {
        // get user auth
        $id = Auth::user()->id;
        $companyName = $request->input('companyName');
        $phonenumber = $request->input('phoneNo');
        $expiryDate = $request->input('validityPass');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        $passportPhoto = $request->file('contractorImg');

        // to rename the contractorinfo file
        $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $passportPhoto->move('assets', $filename);

        $data = array(
            'userID' => $id,
            'companyName' => $companyName,
            'phoneNo' => $phonenumber,
            'passExpiryDate' => $expiryDate,
            'birthDate' => $birthDate,
            'address' => $address,
            'passportPhoto' => $filename,
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
        $companyName = $request->input('companyName');
        $occupation = $request->input('occupation');
        $phonenumber = $request->input('phoneNo');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        $passportPhoto = $request->file('visitorImg');

        // to rename the contractorinfo file
        $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $passportPhoto->move('assets', $filename);

        $data = array(
            'userID' => $id,
            'employeeID' => $employeeID,
            'companyName' => $companyName,
            'occupation' => $occupation,
            'phoneNo' => $phonenumber,
            'birthDate' => $birthDate,
            'address' => $address,
            'passportPhoto' => $filename,
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

    public function contractordetail(Request $request)
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('id', 'desc')
            ->get();

        return view('profile.contractor_detail', compact('companylist'));
    }

    public function visitordetail(Request $request)
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('id', 'desc')
            ->get();

        return view('profile.visitor_detail', compact('companylist'));
    }
}
