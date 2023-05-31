<?php

namespace App\Http\Controllers;

use App\Models\ContractorInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VisitorInfo;
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

    public function updateProfileContractor(Request $request, $id)
    {
        // find the id from contractorinfo

        $contractorinfo = ContractorInfo::find($id);

        if ($request->hasFile('passportPhoto')) {
            //unlink the old contractorinfo file from assets folder
            $path = public_path() . '/assets/avatar' . $contractorinfo->passportPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $contractorinfo->passportPhoto = $request->file('passportPhoto');

            //to rename the contractorinfo file
            $filename = time() . '.' . $contractorinfo->passportPhoto->getClientOriginalExtension();
            // to store the new file by moving to assets folder
            $request->passportPhoto->move('assets/avatar', $filename);

            $contractorinfo->passportPhoto = $filename;
        }

        if ($request->hasFile('validityPassImg')) {
            //unlink the old contractorinfo file from assets folder
            $path = public_path() . '/assets/pass' . $contractorinfo->validityPassPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $contractorinfo->validityPassPhoto = $request->file('validityPassImg');

            //to rename the contractorinfo file
            $filename2 = time() . '.' . $contractorinfo->validityPassPhoto->getClientOriginalExtension();

            // to store the new file by moving to assets folder
            $request->file('validityPassImg')->move('assets/pass', $filename2);

            $contractorinfo->validityPassPhoto = $filename2;
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

    public function updateProfileVisitor(Request $request, $id)
    {
        // find the id from visitorinfo

        $visitorinfo = VisitorInfo::find($id);

        if ($request->hasFile('passportPhoto')) {
            //unlink the old visitorinfo file from assets folder
            $path = public_path() . '/assets/avatar' . $visitorinfo->passportPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $visitorinfo->passportPhoto = $request->file('passportPhoto');

            //to rename the visitorinfo file
            $filename = time() . '.' . $visitorinfo->passportPhoto->getClientOriginalExtension();
            // to store the new file by moving to assets folder
            $request->passportPhoto->move('assets/avatar', $filename);

            $visitorinfo->passportPhoto = $filename;
        }

        $visitorinfo->companyName = $request->input('companyName');
        $visitorinfo->phoneNo = $request->input('phoneNo');
        $visitorinfo->employeeID = $request->input('employeeID');
        $visitorinfo->occupation = $request->input('occupation');
        $visitorinfo->birthDate = $request->input('birthDate');
        $visitorinfo->address = $request->input('address');

        // upadate query in the database
        $visitorinfo->update();

        // display message box in the same page
        return redirect()->back()->with('message', 'Visitor Info Updated Successfully');
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
        $validityPass = $request->file('validityPassImg');

        // to rename the contractorinfo file
        $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $passportPhoto->move('assets/avatar', $filename);

        // to rename the contractorinfo file
        $filename2 = time() . '.' . $validityPass->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $validityPass->move('assets/pass', $filename2);

        $data = array(
            'userID' => $id,
            'companyName' => $companyName,
            'phoneNo' => $phonenumber,
            'passExpiryDate' => $expiryDate,
            'birthDate' => $birthDate,
            'address' => $address,
            'passportPhoto' => $filename,
            'validityPassPhoto' => $filename2,
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
        $passportPhoto->move('assets/avatar', $filename);

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

    public function contractordetail(Request $request)
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('profile.contractor_detail', compact('companylist'));
    }

    public function visitordetail(Request $request)
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('profile.visitor_detail', compact('companylist'));
    }

    public function changepassword($id)
    {
        return view('profile.change_password');
    }
}
