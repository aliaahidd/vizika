<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailUserApproval;
use App\Mail\EmailAccountRegistered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ContractorInfo;
use App\Models\VisitorInfo;
use App\Models\AppointmentInfo;
use App\Models\VisitRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;



class ProfileController extends Controller
{
    public function loadProfile($id)
    {
        $id = Auth::user()->id;

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
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
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'visitorinfo.id AS visitID', 'users.*', 'visitorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        return view('profile.edit_profile', compact('contractor', 'visitor', 'companylist'));
    }

    //choose visitor form page
    public function userlist()
    {
        $visitorlist = DB::table('users')
            ->where('category', 'Visitor')
            ->orwhere('category', 'Contractor')
            ->orderBy('name', 'asc')
            ->get();

        return view('profile.user_list', compact('visitorlist'));
    }

    //choose visitor form page (registered by staff)
    public function registeredby()
    {
        $id = Auth::user()->id;

        $visitorlist = DB::table('users')
            ->where('category', 'Visitor')
            ->orwhere('category', 'Contractor')
            ->where('recommendedBy', $id)
            ->orderBy('name', 'asc')
            ->get();

        return view('profile.registeredby', compact('visitorlist'));
    }

    public function registeredprofile($id)
    {
        $usertype = DB::table('users')
            ->where('id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'visitorinfo.id AS visitID', 'users.*', 'visitorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();


        return view('profile.profile_registered', compact('usertype', 'visitor', 'contractor'));
    }

    public function approveuser($id)
    {
        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Active';
        $userStatus->update();

        //send email
        $data = array(
            'name'                =>  $userStatus->name,
            'email'               =>  $userStatus->email,
        );

        $to = [
            [
                'email' => $userStatus->email,
            ]
        ];

        //send email 
        Mail::to($to)->send(new EmailUserApproval($data));

        return redirect()->route('registeredby');
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
        $id = Auth::user()->id;

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
            'status' => 'Registered',
            'recommendedBy' => $id,
        );

        // insert query
        DB::table('users')->insert($data);

        //send email
        $data = array(
            'name'                =>  $name,
            'email'               =>  $email,
        );

        $to = [
            [
                'email' => $email,
            ]
        ];

        //send email 
        Mail::to($to)->send(new EmailAccountRegistered($data));


        sleep(1);
        return redirect()->route('userlist');
    }

    public function registerbulkfile(Request $request)
    {
        $id = Auth::user()->id;
        $category = $request->input('category');
        $password = Hash::make('visitor123');
        $companyID = $request->input('companyID');

        if ($request->hasFile('file') && $request->file('file')->getClientOriginalExtension() === 'csv') {
            $file = $request->file('file');
            $handle = fopen($file->getPathname(), "r");
            $firstRowSkipped = false; // Flag to track if the first row has been skipped

            while ($data = fgetcsv($handle)) {
                if (!$firstRowSkipped) {
                    $firstRowSkipped = true;
                    continue; // Skip the first row and move to the next iteration
                }

                $data[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data[0]);
                $nameCSV = $data[0];
                $emailCSV = $data[1];
                $empNoCSV = $data[2];
                $phoneNoCSV = $data[3];
                $passExpiryDateCSV = $data[4];
                $birthDateCSV = $data[5];
                $addressCSV = $data[6];
                $validityPassPhotoCSV = $data[7];

                //change format date 
                $carbonBirthDate = Carbon::createFromFormat('d/m/Y', $birthDateCSV);
                $birthDate = $carbonBirthDate->format('Y-m-d');

                $carbonPassExpiryDate = Carbon::createFromFormat('d/m/Y', $passExpiryDateCSV);
                $passExpiryDate = $carbonPassExpiryDate->format('Y-m-d');


                $query = "INSERT INTO users(name, email, password, category, status, recommendedBy) VALUES (?, ?, ?, ?, ?, ?)";
                DB::insert($query, [$nameCSV, $emailCSV, $password, $category, 'Pending', $id]);

                // Get the last inserted ID (primary key) from 'users' table
                $contractorID = DB::getPdo()->lastInsertId();

                $query = "INSERT INTO contractorinfo(userID, companyID, employeeNo, phoneNo, passExpiryDate, birthDate, address, validityPassPhoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                DB::insert($query, [$contractorID, $companyID, $empNoCSV, $phoneNoCSV, $passExpiryDate, $birthDate, $addressCSV, $validityPassPhotoCSV]);
            }

            fclose($handle);
            return redirect()->back()->with('success', 'Success');
        } else {
            return redirect()->back()->with('error', 'Sila muat naik fail CSV sahaja');
        }
    }

    public function updateProfileContractor(Request $request, $id)
    {
        // find the id from contractorinfo

        $contractorinfo = ContractorInfo::find($id);

        // if ($request->hasFile('passportPhoto')) {
        //     $name = Auth::user()->name;
        //     //unlink the old contractorinfo file from assets folder
        //     $path = public_path() . '/assets/' . $name . $contractorinfo->passportPhoto;
        //     if (file_exists($path)) {
        //         unlink($path);
        //     }

        //     $name = Auth::user()->name;

        //     $contractorinfo->passportPhoto = $request->file('passportPhoto');

        //     //to rename the contractorinfo file
        //     $filename = time() . '.' . $contractorinfo->passportPhoto->getClientOriginalExtension();
        //     // to store the new file by moving to assets folder
        //     $request->passportPhoto->move('assets/' . $name, $filename);

        //     $contractorinfo->passportPhoto = $filename;
        // }

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
        $contractorinfo->employeeNo = $request->input('employeeNo');
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

        // if ($request->hasFile('passportPhoto')) {
        //     $name = Auth::user()->name;

        //     //unlink the old visitorinfo file from assets folder
        //     $path = public_path() . '/assets/' . $name . $visitorinfo->passportPhoto;
        //     if (file_exists($path)) {
        //         unlink($path);
        //     }

        //     $name = Auth::user()->name;

        //     $visitorinfo->passportPhoto = $request->file('passportPhoto');

        //     //to rename the visitorinfo file
        //     $filename = time() . '.' . $visitorinfo->passportPhoto->getClientOriginalExtension();
        //     // to store the new file by moving to assets folder
        //     $request->passportPhoto->move('assets/' . $name, $filename);

        //     $visitorinfo->passportPhoto = $filename;
        // }

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

        // Check if the user ID already exists
        $existingContractor = DB::table('contractorinfo')->where('userID', $id)->first();
        if ($existingContractor) {

            $contractorinfo = ContractorInfo::where('userID', $id)->first();

            // if ($request->hasFile('passportPhoto')) {
            //     $name = Auth::user()->name;
            //     //unlink the old contractorinfo file from assets folder
            //     $path = public_path() . '/assets/' . $name . $contractorinfo->passportPhoto;
            //     if (file_exists($path)) {
            //         unlink($path);
            //     }

            //     $name = Auth::user()->name;

            //     $contractorinfo->passportPhoto = $request->file('passportPhoto');

            //     //to rename the contractorinfo file
            //     $filename = time() . '.' . $contractorinfo->passportPhoto->getClientOriginalExtension();
            //     // to store the new file by moving to assets folder
            //     $request->passportPhoto->move('assets/' . $name, $filename);

            //     $contractorinfo->passportPhoto = $filename;
            // }

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

            return redirect()->route('registerBiometric');
        }

        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Pending';
        $userStatus->update();

        $companyID = $request->input('companyID');
        $employeeNo = $request->input('employeeNo');
        $phonenumber = $request->input('phoneNo');
        $expiryDate = $request->input('validityPass');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        // $passportPhoto = $request->file('contractorImg');
        $validityPass = $request->file('validityPassImg');

        // $name = Auth::user()->name;

        // // to rename the contractorinfo file
        // $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // // to store the file by moving to assets folder
        // $passportPhoto->move('assets/' . $name, $filename);

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
            // 'passportPhoto' => $filename,
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

        // Check if the user ID already exists
        $existingVisitor = DB::table('visitorinfo')->where('userID', $id)->first();
        if ($existingVisitor) {

            $visitorinfo = VisitorInfo::where('userID', $id)->first();

            // if ($request->hasFile('passportPhoto')) {
            //     $name = Auth::user()->name;

            //     //unlink the old visitorinfo file from assets folder
            //     $path = public_path() . '/assets/' . $name . $visitorinfo->passportPhoto;
            //     if (file_exists($path)) {
            //         unlink($path);
            //     }

            //     $name = Auth::user()->name;

            //     $visitorinfo->passportPhoto = $request->file('passportPhoto');

            //     //to rename the visitorinfo file
            //     $filename = time() . '.' . $visitorinfo->passportPhoto->getClientOriginalExtension();
            //     // to store the new file by moving to assets folder
            //     $request->passportPhoto->move('assets/' . $name, $filename);

            //     $visitorinfo->passportPhoto = $filename;
            // }

            $visitorinfo->companyID = $request->input('companyID');
            $visitorinfo->phoneNo = $request->input('phoneNo');
            $visitorinfo->employeeNo = $request->input('employeeNo');
            $visitorinfo->occupation = $request->input('occupation');
            $visitorinfo->birthDate = $request->input('birthDate');
            $visitorinfo->address = $request->input('address');

            // upadate query in the database
            $visitorinfo->update();

            return redirect()->route('registerBiometric');
        }

        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Pending';
        $userStatus->update();

        $employeeNo = $request->input('employeeNo');
        $companyID = $request->input('companyID');
        $occupation = $request->input('occupation');
        $phonenumber = $request->input('phoneNo');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        // $passportPhoto = $request->file('visitorImg');

        // $name = Auth::user()->name;

        // // to rename the contractorinfo file
        // $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // // to store the file by moving to assets folder
        // $passportPhoto->move('assets/' . $name, $filename);

        $data = array(
            'userID' => $id,
            'employeeNo' => $employeeNo,
            'companyID' => $companyID,
            'occupation' => $occupation,
            'phoneNo' => $phonenumber,
            'birthDate' => $birthDate,
            'address' => $address,
            // 'passportPhoto' => $filename,
        );

        // insert query
        DB::table('visitorinfo')->insert($data);

        return redirect()->route('registerBiometric');
    }

    public function bulkregistration()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('profile.bulk_registration', compact('companylist'));
    }

    public function exceldownload($fileType)
    {
        // Replace 'public/excels/your_file.xlsx' with the actual path to your Excel file.
        $contractorFilePath  = public_path('excel/guideline_contractor_registration.csv');
        $visitorFilePath = public_path('excel/guideline_visitor_registration.csv');


        if ($fileType === 'contractor') {
            if (file_exists($contractorFilePath)) {
                return response()->download($contractorFilePath, 'guideline_contractor_registration.csv');
            }
        } elseif ($fileType === 'visitor') {
            if (file_exists($visitorFilePath)) {
                return response()->download($visitorFilePath, 'guideline_visitor_registration.csv');
            }
        }

        // If the file doesn't exist, return an error response or redirect to an error page.
        abort(404, 'File not found');
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

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
