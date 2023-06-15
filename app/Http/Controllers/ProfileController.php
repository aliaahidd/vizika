<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ContractorInfo;
use App\Models\VisitorInfo;
use App\Models\AppointmentInfo;
use App\Models\VisitRecord;
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

        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        return view('profile.profile', compact('contractor', 'visitor', 'user'));
    }

    public function editprofile($id)
    {
        $id = Auth::user()->id;

        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*', 'companyinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'visitorinfo.id AS visitID', 'users.*', 'visitorinfo.*', 'companyinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        return view('profile.edit_profile', compact('contractor', 'visitor', 'companylist'));
    }

    //choose visitor form page
    public function userlist(Request $request)
    {
        $visitorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Visitor')
            ->orwhere('category', 'Contractor')
            ->get();

        return view('profile.user_list', compact('visitorlist'));
    }

    public function registeruserform()
    {
        return view('profile.register_visitor');
    }

    //register visitor (by staff)
    public function registervisitor(Request $request)
    {
        // create visitor account 
        // get user auth
        $name = $request->input('name');
        $email = $request->input('email');
        $category = $request->input('category');
        $password = Str::random(10);

        $Email = User::where('email', $email)->first();
        if ($Email) {
            return redirect()
                ->route('registeruserform')
                ->with('message', 'Email is already exists.');
        }

        $publicFolderPath = public_path('assets/' . $name);

        // Create the folder
        try {
            if (!is_dir($publicFolderPath)) {
                mkdir($publicFolderPath, 0755, true);
            }
        } catch (\Exception $e) {
            return "An error occurred: " . $e->getMessage();
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('visitor123'),
            'category' => $category,
        );

        // insert query
        DB::table('users')->insert($data);

        sleep(1);
        return redirect()->route('userlist');
    }

    public function updateProfileContractor(Request $request, $id)
    {
        // find the id from contractorinfo

        $contractorinfo = ContractorInfo::find($id);

        if ($request->hasFile('passportPhoto')) {
            $name = Auth::user()->name;
            //unlink the old contractorinfo file from assets folder
            $path = public_path() . '/assets/' . $name . $contractorinfo->passportPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = Auth::user()->name;

            $contractorinfo->passportPhoto = $request->file('passportPhoto');

            //to rename the contractorinfo file
            $filename = time() . '.' . $contractorinfo->passportPhoto->getClientOriginalExtension();
            // to store the new file by moving to assets folder
            $request->passportPhoto->move('assets/' . $name, $filename);

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

        $contractorinfo->companyID = $request->input('companyID');
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
            $name = Auth::user()->name;

            //unlink the old visitorinfo file from assets folder
            $path = public_path() . '/assets/' . $name . $visitorinfo->passportPhoto;
            if (file_exists($path)) {
                unlink($path);
            }

            $name = Auth::user()->name;

            $visitorinfo->passportPhoto = $request->file('passportPhoto');

            //to rename the visitorinfo file
            $filename = time() . '.' . $visitorinfo->passportPhoto->getClientOriginalExtension();
            // to store the new file by moving to assets folder
            $request->passportPhoto->move('assets/' . $name, $filename);

            $visitorinfo->passportPhoto = $filename;
        }

        $visitorinfo->companyID = $request->input('companyID');
        $visitorinfo->phoneNo = $request->input('phoneNo');
        $visitorinfo->employeeNo = $request->input('employeeNo');
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
        $companyID = $request->input('companyID');
        $employeeNo = $request->input('employeeNo');
        $phonenumber = $request->input('phoneNo');
        $expiryDate = $request->input('validityPass');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        $passportPhoto = $request->file('contractorImg');
        $validityPass = $request->file('validityPassImg');

        $name = Auth::user()->name;

        // to rename the contractorinfo file
        $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $passportPhoto->move('assets/' . $name, $filename);

        // to rename the contractorinfo file
        $filename2 = time() . '.' . $validityPass->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $validityPass->move('assets/pass', $filename2);

        $data = array(
            'userID' => $id,
            'employeeNo' => $employeeNo,
            'companyID' => $companyID,
            'phoneNo' => $phonenumber,
            'passExpiryDate' => $expiryDate,
            'birthDate' => $birthDate,
            'address' => $address,
            'passportPhoto' => $filename,
            'validityPassPhoto' => $filename2,
        );

        // insert query
        DB::table('contractorinfo')->insert($data);

        return redirect()->route('registerBiometric');
    }

    public function storevisitorinfo(Request $request)
    {
        // get user auth
        $id = Auth::user()->id;
        $employeeNo = $request->input('employeeNo');
        $companyID = $request->input('companyID');
        $occupation = $request->input('occupation');
        $phonenumber = $request->input('phoneNo');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        $passportPhoto = $request->file('visitorImg');

        $name = Auth::user()->name;

        // to rename the contractorinfo file
        $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // to store the file by moving to assets folder
        $passportPhoto->move('assets/' . $name, $filename);

        $data = array(
            'userID' => $id,
            'employeeNo' => $employeeNo,
            'companyID' => $companyID,
            'occupation' => $occupation,
            'phoneNo' => $phonenumber,
            'birthDate' => $birthDate,
            'address' => $address,
            'passportPhoto' => $filename,
        );

        // insert query
        DB::table('visitorinfo')->insert($data);

        return redirect()->route('registerBiometric');
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

    public function stafflist()
    {
        $stafflist = DB::table('users')
            ->where('category', 'Staff')
            ->orderBy('name', 'asc')
            ->get();

        return view('profile.staff_list', compact('stafflist'));
    }

    public function deleteStaff(Request $request, $id)
    {
        if ($request->ajax()) {
            User::where('id', '=', $id)->delete();

            // Get the appointment IDs associated with the staff
            $appointmentIds = AppointmentInfo::where('staffID', '=', $id)->pluck('id');

            // Delete VisitRecord records based on the appointment IDs
            VisitRecord::whereIn('appointmentID', $appointmentIds)->delete();

            // Delete AppointmentInfo records
            AppointmentInfo::where('staffID', '=', $id)->delete();

            return response()->json(array('success' => true));
        }
    }

    public function changepassword($id)
    {
        return view('profile.change_password');
    }
}
