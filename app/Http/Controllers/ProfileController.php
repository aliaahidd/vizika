<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailUserApproval;
use App\Mail\EmailAccountRegistered;
use App\Mail\EmailUserRejection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ContractorInfo;
use App\Models\VisitorInfo;
use App\Models\AppointmentInfo;
use App\Models\CompanyInfo;
use App\Models\VisitRecord;
use App\Models\UserChangeRequest;
use App\Rules\UniqueCompanyRegNo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use App\Rules\UniqueICNumber;
use Illuminate\Validation\Rule;




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
            ->orwhere('category', 'Company')
            ->orderBy('name', 'asc')
            ->get();

        $contractorlist = DB::table('users')
            ->where('category', 'Contractor')
            ->orderBy('name', 'asc')
            ->get();

        return view('profile.user_list', compact('visitorlist', 'contractorlist'));
    }

    //choose visitor form page (registered by staff)
    public function registeredby()
    {
        $id = Auth::user()->id;

        $visitorlist = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->leftJoin('briefingsession', 'briefingsession.contractorID', '=', 'users.id')
            ->leftJoin('safetybriefinginfo', 'safetybriefinginfo.id', '=', 'briefingsession.briefingID')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*', 'briefingsession.*', 'safetybriefinginfo.*'
            ])
            ->where('status', 'Pending')
            ->get();

        return view('profile.registeredby', compact('visitorlist'));
    }

    public function registeredbyvisitor()
    {
        $id = Auth::user()->id;

        $visitorlist = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'visitorinfo.id AS contID', 'users.*', 'visitorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('status', 'Pending')
            ->get();

        return view('profile.registeredbyvisitor', compact('visitorlist'));
    }

    //list name edit profile approval 
    public function editprofileapproval()
    {
        $id = Auth::user()->id;

        $changerequests = DB::table('userchangerequests')
            ->join('users', 'users.id', '=', 'userchangerequests.userID')
            ->leftjoin('companyinfo', 'companyinfo.id', '=', 'users.companyID')
            ->select([
                'users.id AS sessionID',
                'userchangerequests.id AS changeRequestID',
                'users.*', 'userchangerequests.*', 'companyinfo.*'
            ])
            ->where('userchangerequests.requestStatus', 'Pending')
            ->get();

        return view('profile.edit_profile_requests', compact('changerequests'));
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
            ->leftJoin('briefingsession', 'briefingsession.contractorID', '=', 'users.id')
            ->leftJoin('safetybriefinginfo', 'safetybriefinginfo.id', '=', 'briefingsession.briefingID')
            ->select([
                'users.id AS sessionID',
                'companyinfo.id AS companyID',
                'contractorinfo.id AS contID', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*', 'briefingsession.*', 'safetybriefinginfo.*'
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

        $currentDate = Carbon::today();
        $sixMonthsAfter = $currentDate->addMonths(6);

        $contractorinfo = ContractorInfo::where('userID', $id)->first();
        $contractorinfo->passExpiryDate = $sixMonthsAfter;

        // upadate query in the database
        $contractorinfo->update();

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

    public function approvechangerequests($id)
    {
        // Update contractorinfo table
        DB::table('contractorinfo')
            ->join('userchangerequests', 'contractorinfo.userID', '=', 'userchangerequests.userID')
            ->where('userchangerequests.id', $id)
            ->update([
                'contractorinfo.passStatus' => null,
            ]);

        // Update userchangerequests table
        DB::table('userchangerequests')
            ->where('id', $id)
            ->update([
                'requestStatus' => 'Approved',
            ]);

        return redirect()->route('editprofileapproval');
    }

    public function rejectuser(Request $request, $id)
    {
        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Rejected';
        $userStatus->update();

        $reasonReject = $request->input('reasonReject');

        //send email
        $data = array(
            'name'                =>  $userStatus->name,
            'email'               =>  $userStatus->email,
            'reason'              =>  $reasonReject,
        );

        $to = [
            [
                'email' => $userStatus->email,
            ]
        ];

        //send email 
        Mail::to($to)->send(new EmailUserRejection($data));

        return redirect()->route('registeredby');
    }

    public function approveallregistration()
    {

        $pendingUsers = User::where('status', 'Pending')->get();

        foreach ($pendingUsers as $user) {
            $user->status = 'Active';
            $user->update();
        }

        //send email
        // $data = array(
        //     'name'                =>  $userStatus->name,
        //     'email'               =>  $userStatus->email,
        // );

        // $to = [
        //     [
        //         'email' => $userStatus->email,
        //     ]
        // ];

        // //send email 
        // Mail::to($to)->send(new EmailUserApproval($data));

        return redirect()->route('registeredby');
    }

    public function registeruserform()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('profile.register_visitor', compact('companylist'));
    }

    //register visitor (by staff)
    public function sendinvitationemail(Request $request)
    {
        // create visitor account 
        // get user auth
        $id = Auth::user()->id;

        $name = $request->input('name');
        $email = $request->input('email');
        $category = $request->input('category');

        $data = array(
            'name' => $name,
            'email' => $email,
            'category' => $category,
        );

        //send email
        $data = array(
            'name'                =>  $name,
            'email'               =>  $email,
            'category'            =>  $category,
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

    //register visitor (by staff)
    public function registervisitor(Request $request)
    {
        $request->validate([
            'icNo' => ['required', 'string', 'max:255', new UniqueICNumber],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
        ]);

        $icNo = $request->input('icNo');
        $email = $request->input('email');
        $password = $request->input('password');
        $companyID = $request->input('companyID');

        $Email = User::where('email', $email)->first();
        if ($Email) {
            return redirect()->back()->with('success', 'Email already exists');
        }

        $data = array(
            'icNo' => $icNo,
            'name' => 'Default',
            'email' => $email,
            'password' => Hash::make($password),
            'category' => 'Visitor',
            'status' => 'Pending',
            'companyID' => $companyID,
        );

        // insert query
        DB::table('users')->insert($data);

        sleep(1);
        return redirect()->route('login')->with('success', 'Registration successful. Please login with your credentials.');
    }

    //register contractor
    public function registercontractor(Request $request)
    {
        $request->validate([
            'icNo' => ['required', 'string', 'max:255', new UniqueICNumber],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
        ]);

        // create visitor account 
        // get user auth
        $icNo = $request->input('icNo');
        $email = $request->input('email');
        $password = $request->input('password');
        $companyID = $request->input('companyID');

        $Email = User::where('email', $email)->first();
        if ($Email) {
            return redirect()->back()->with('success', 'Email already exists');
        }

        $data = array(
            'icNo' => $icNo,
            'name' => 'Default',
            'email' => $email,
            'password' => Hash::make($password),
            'category' => 'Contractor',
            'status' => 'Pending',
            'companyID' => $companyID,
        );

        // insert query
        DB::table('users')->insert($data);

        sleep(1);
        return redirect()->route('login')->with('success', 'Registration successful. Please login with your credentials.');
    }

    //register company
    public function registercompany(Request $request)
    {
        $request->validate([
            'companyRegNo' => ['required', 'string', 'max:255', new UniqueCompanyRegNo],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
        ]);
        // create visitor account 
        // get user auth
        $companyRegNo = $request->input('companyRegNo');
        $email = $request->input('email');
        $password = $request->input('password');

        $staffID = $request->input('staffID');
        $mngtPICName = $request->input('mngtPICName');
        $mngtPICEmail = $request->input('mngtPICEmail');
        $safetyPICName = $request->input('safetyPICName');
        $safetyPICEmail = $request->input('safetyPICEmail');

        $Email = User::where('email', $email)->first();
        if ($Email) {
            return redirect()->back()->with('success', 'Email already exists');
        }

        $data = array(
            'companyRegNo' => $companyRegNo,
            'name' => 'Default',
            'email' => $email,
            'password' => Hash::make($password),
            'category' => 'Company',
            'status' => 'Pending',
        );

        // insert query
        $userId = DB::table('users')->insertGetId($data);

        $data = array(
            'userID' => $userId,
            'staffID' => $staffID,
            'mngtPICName' => $mngtPICName,
            'mngtPICEmail' => $mngtPICEmail,
            'safetyPICName' => $safetyPICName,
            'safetyPICEmail' => $safetyPICEmail,
        );

        // insert query
        DB::table('companyinfo')->insert($data);

        sleep(1);
        return redirect()->route('login')->with('success', 'Registration successful. Please login with your credentials.');
    }

    public function updateProfileContractor(Request $request, $id)
    {
        // find the id from contractorinfo

        $userID = Auth::user()->id;

        $contractorinfo = ContractorInfo::find($id);


        if ($request->hasFile('validityPassImg')) {
            //unlink the old contractorinfo file from assets folder
            // $path = public_path() . '/assets/pass' . $contractorinfo->validityPassPhoto;
            // if (file_exists($path)) {
            //     unlink($path);
            // }

            // $contractorinfo->validityPassPhoto = $request->file('validityPassImg');

            //to rename the contractorinfo file
            $filename2 = time() . '.' . $request->file('validityPassImg')->getClientOriginalExtension();

            // to store the new file by moving to assets folder
            $request->file('validityPassImg')->move('assets/pass', $filename2);

            $contractorinfo->validityPassPhoto = $filename2;
        }

        // Initialize an array to store the changes
        $changes = [];

        if ($request->input('phoneNo') !== $contractorinfo->phoneNo) {
            $changes[] = [
                'field' => 'phoneNo',
                'old_value' => $contractorinfo->phoneNo,
                'new_value' => $request->input('phoneNo'),
            ];
        }

        if (trim($request->input('companyID')) !== trim($contractorinfo->companyID)) {
            $companyinfoold = CompanyInfo::find($contractorinfo->companyID);

            $companyinfonew = CompanyInfo::find($request->input('companyID'));

            $changes[] = [
                'field' => 'companyID',
                'old_value' => $companyinfoold->companyName,
                'new_value' => $companyinfonew->companyName,
            ];
        }

        if ($request->input('address') !== $contractorinfo->address) {
            $changes[] = [
                'field' => 'address',
                'old_value' => $contractorinfo->address,
                'new_value' => $request->input('address'),
            ];
        }

        if ($request->input('employeeNo') !== $contractorinfo->employeeNo) {
            $changes[] = [
                'field' => 'employeeNo',
                'old_value' => $contractorinfo->employeeNo,
                'new_value' => $request->input('employeeNo'),
            ];
        }

        if ($request->input('passExpiryDate') !== $contractorinfo->passExpiryDate) {
            $changes[] = [
                'field' => 'passExpiryDate',
                'old_value' => $contractorinfo->passExpiryDate,
                'new_value' => $request->input('passExpiryDate'),
            ];
        }

        if ($request->input('birthDate') !== $contractorinfo->birthDate) {
            $changes[] = [
                'field' => 'birthDate',
                'old_value' => $contractorinfo->birthDate,
                'new_value' => $request->input('birthDate'),
            ];
        }

        // Store the changes in your database or log them
        foreach ($changes as $change) {
            $userChange = new UserChangeRequest();
            $userChange->userID = $userID;
            $userChange->field_changed = $change['field'];
            $userChange->original_value = $change['old_value'];
            $userChange->new_value = $change['new_value'];
            $userChange->requestStatus = 'Pending';
            $userChange->save();
        }

        $contractorinfo->companyID = $request->input('companyID');
        $contractorinfo->phoneNo = $request->input('phoneNo');
        $contractorinfo->employeeNo = $request->input('employeeNo');
        $contractorinfo->passExpiryDate = $request->input('passExpiryDate');
        $contractorinfo->birthDate = $request->input('birthDate');
        $contractorinfo->address = $request->input('address');
        $contractorinfo->passStatus = 'Inactive';

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


            $contractorinfo->companyID = $request->input('companyID');
            // $contractorinfo->icNo = $request->input('icNo');
            $contractorinfo->phoneNo = $request->input('phoneNo');
            // $contractorinfo->passExpiryDate = $request->input('passExpiryDate');
            $contractorinfo->birthDate = $request->input('birthDate');
            $contractorinfo->address = $request->input('address');

            // upadate query in the database
            $contractorinfo->update();

            return redirect()->route('bookbriefing');
        }

        
        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Pending';
        $userStatus->update();

        $companyID = $request->input('companyID');
        $name = $request->input('name');
        $employeeNo = $request->input('employeeNo');
        $phonenumber = $request->input('phoneNo');
        // $expiryDate = $request->input('validityPass');
        $birthDate = $request->input('birthDate');
        $address = $request->input('address');
        // $passportPhoto = $request->file('contractorImg');
        // $validityPass = $request->file('validityPassImg');

        // $name = Auth::user()->name;

        // // to rename the contractorinfo file
        // $filename = time() . '.' . $passportPhoto->getClientOriginalExtension();

        // // to store the file by moving to assets folder
        // $passportPhoto->move('assets/' . $name, $filename);

        // GUNA NANTI
        // to rename the contractorinfo file
        // $filename2 = time() . '.' . $validityPass->getClientOriginalExtension();

        // // to store the file by moving to assets folder
        // $validityPass->move('assets/pass', $filename2);

        $userinfo = User::where('id', $id)->first();
        $userinfo->name = $request->input('name');

        // upadate query in the database
        $userinfo->update();

        $data = array(
            'userID' => $id,
            'employeeNo' => $employeeNo,
            'companyID' => $userinfo->companyID,
            'phoneNo' => $phonenumber,
            // 'passExpiryDate' => $expiryDate,
            'birthDate' => $birthDate,
            'address' => $address,
            // 'passportPhoto' => $filename,
            // 'validityPassPhoto' => $filename2,
        );

        // insert query
        DB::table('contractorinfo')->insert($data);

        $publicFolderPath = public_path('assets/' . $name);

        // Create the folder
        try {
            if (!is_dir($publicFolderPath)) {
                mkdir($publicFolderPath, 0755, true);
            }
        } catch (\Exception $e) {
            return "An error occurred: " . $e->getMessage();
        }

        return redirect()->route('bookbriefing');
    }

    public function updateBriefingInfo(Request $request, $id)
    {

        $contractorinfo = ContractorInfo::find($id);

        if ($request->hasFile('validityPassImg')) {

            //to rename the contractorinfo file
            $filename2 = time() . '.' . $request->file('validityPassImg')->getClientOriginalExtension();

            // to store the new file by moving to assets folder
            $request->file('validityPassImg')->move('assets/pass', $filename2);

            $contractorinfo->validityPassPhoto = $filename2;
        }

        $contractorinfo->passExpiryDate = $request->input('validityPass');

        // upadate query in the database
        $contractorinfo->update();

        // display message box in the same page
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
            //$visitorinfo->icNo = $request->input('icNo');
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
        $name = $request->input('name');
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

        $userinfo = User::where('id', $id)->first();
        $userinfo->name = $request->input('name');

        // upadate query in the database
        $userinfo->update();

        $data = array(
            'userID' => $id,
            'employeeNo' => $employeeNo,
            'companyID' => $userinfo->companyID,
            //'icNo' => $icNo,
            'occupation' => $occupation,
            'phoneNo' => $phonenumber,
            'birthDate' => $birthDate,
            'address' => $address,
            // 'passportPhoto' => $filename,
        );

        // insert query
        DB::table('visitorinfo')->insert($data);

        $publicFolderPath = public_path('assets/' . $name);

        // Create the folder
        try {
            if (!is_dir($publicFolderPath)) {
                mkdir($publicFolderPath, 0755, true);
            }
        } catch (\Exception $e) {
            return "An error occurred: " . $e->getMessage();
        }

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
        $contractorFilePath  = public_path('excel/guideline_contractor_registration.xlsx');
        $visitorFilePath = public_path('excel/guideline_visitor_registration.xlsx');


        if ($fileType === 'contractor') {
            if (file_exists($contractorFilePath)) {
                return response()->download($contractorFilePath, 'guideline_contractor_registration.xlsx');
            }
        } elseif ($fileType === 'visitor') {
            if (file_exists($visitorFilePath)) {
                return response()->download($visitorFilePath, 'guideline_visitor_registration.xlsx');
            }
        }

        // If the file doesn't exist, return an error response or redirect to an error page.
        abort(404, 'File not found');
    }

    public function registerbulkfile(Request $request)
    {
        $id = Auth::user()->id;
        $category = $request->input('category');
        $password = Hash::make('visitor123');
        $companyID = $request->input('companyID');

        // Validate the uploaded files
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
            'zipfile' => 'required|mimes:zip',
        ]);

        // Process the Excel file
        $excelFile = $request->file('file');
        $excelData = $this->readExcelData($excelFile->getPathname());

        // Process the Zip file
        $zipFile = $request->file('zipfile');
        $zipData = $this->readZipData($zipFile->getPathname());

        // Example: Save contractor details and associate images with their names
        foreach ($excelData as $row) {

            $nameCSV = $row['Name'];
            $emailCSV = $row['Email'];
            $empNoCSV = $row['EmpNo'];
            $phoneNoCSV = $row['PhoneNo'];
            $passExpiryDateCSV = $row['PassExpiryDate'];
            $birthDateCSV = $row['BirthDate'];
            $addressCSV = $row['Address'];

            // Change format date 
            $carbonBirthDate = Carbon::createFromFormat('d/m/Y', $birthDateCSV);
            $birthDate = $carbonBirthDate->format('Y-m-d');

            $carbonPassExpiryDate = Carbon::createFromFormat('d/m/Y', $passExpiryDateCSV);
            $passExpiryDate = $carbonPassExpiryDate->format('Y-m-d');

            $query = "INSERT INTO users(name, email, password, category, status, companyID) VALUES (?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$nameCSV, $emailCSV, $password, $category, 'Pending', $id]);

            // Get the last inserted ID (primary key) from 'users' table
            $contractorID = DB::getPdo()->lastInsertId();

            // Example: Save the associated image to a directory
            if (isset($zipData[$nameCSV])) {
                $biometricPhotoSubfolderPath = public_path('assets/' . $nameCSV);

                if (!file_exists($biometricPhotoSubfolderPath)) {
                    mkdir($biometricPhotoSubfolderPath, 0777, true);
                }
                $imageContents = $zipData[$nameCSV];
                // Save the image to the public folder
                $biometricPhotoFilename = time() . '.' . 'jpg';
                file_put_contents(public_path('assets/' . $nameCSV . '/' . $biometricPhotoFilename), $imageContents);
            }

            $query2 = "INSERT INTO contractorinfo(userID, companyID, employeeNo, phoneNo, passExpiryDate, birthDate, address, validityPassPhoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query2, [$contractorID, $companyID, $empNoCSV, $phoneNoCSV, $passExpiryDate, $birthDate, $addressCSV, 'aaa']);

            $query3 = "INSERT INTO biometricinfo(userID, facialRecognition) VALUES (?, ?)";
            DB::insert($query3, [$contractorID, $biometricPhotoFilename]);
        }

        return redirect()->back()->with('success', 'Upload and processing completed.');
    }

    private function readExcelData($filePath)
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            $header = array_shift($rows);
            $data = [];
            foreach ($rows as $row) {
                $data[] = array_combine($header, $row);
            }
            return $data;
        } catch (Exception $e) {
            // Handle exceptions if necessary
            return [];
        }
    }

    private function readZipData($filePath)
    {
        $zipData = [];
        $zip = new \ZipArchive;
        if ($zip->open($filePath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                $fileContents = $zip->getFromIndex($i);
                $zipData[pathinfo($filename, PATHINFO_FILENAME)] = $fileContents;
            }
            $zip->close();
        }
        return $zipData;
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
