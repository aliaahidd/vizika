<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailWaitingApproval;
use App\Models\BiometricInfo;
use App\Models\ContractorInfo;

class BiometricController extends Controller
{
    public function facialRecog()
    {
        return view('biometric.biometric');
    }

    public function registerBiometric()
    {
        $id = Auth::user()->id;

        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        if ($user->category == "Contractor") {
            $usertype = DB::table('contractorinfo')
                ->join('users', 'users.id', '=', 'contractorinfo.userID')
                ->where('users.id', $id)
                ->first();
        } else if ($user->category == "Visitor") {
            $usertype = DB::table('visitorinfo')
                ->join('users', 'users.id', '=', 'visitorinfo.userID')
                ->where('users.id', $id)
                ->first();
        }

        return view('biometric.register_biometric', compact('usertype'));
    }

    public function saveImage(Request $request)
    {
        $userID = Auth::user()->id;

        // Check if the user ID already exists
        $existingBiometric = DB::table('biometricinfo')->where('userID', $userID)->first();
        if ($existingBiometric) {
            $user = DB::table('users')->where('id', $userID)->first();
            $name = $user->name;

            $imageData = $request->input('image');
            $fileName = uniqid() . '.jpg';
            $path = 'assets/' . $name . '/' . $fileName;

            // Unlink the previous file
            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }

            file_put_contents(public_path($path), base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

            // Update the record
            DB::table('biometricinfo')
                ->where('userID', $userID)
                ->update(['facialRecognition' => $fileName]);

            return response()->json(['message' => 'Image saved successfully']);
        }

        $user = DB::table('users')->where('id', $userID)->first();
        $name = $user->name; // Access the name property of the retrieved user object

        $imageData = $request->input('image');

        // Generate a unique file name
        $fileName = uniqid() . '.jpg';

        // Save the image file in the assets directory
        $path = 'assets/' . $name . '/' . $fileName; // Add a separator (/) between name and filename
        file_put_contents(public_path($path), base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

        // Save the file name (path) to the database
        $image = new BiometricInfo();
        $image->userID = $userID;
        $image->facialRecognition = $fileName;
        $image->save();

        // $data = array(
        //     'name'                =>  $staff->name,
        //     'email'               =>  $staff->email,
        // );

        // $to = [
        //     [
        //         'email' => $staff->email,
        //     ]
        // ];

        // //send email 
        // Mail::to($to)->send(new EmailWaitingApproval($data));

        return response()->json(['message' => 'Image saved successfully']);
    }

    public function scanBiometric($id)
    {
        $user = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->where('appointmentinfo.id', $id)
            ->first();

        if ($user->category == "Contractor") {
            $usertype = DB::table('appointmentinfo')
                ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
                ->join('contractorinfo', 'contractorinfo.userID', '=', 'appointmentinfo.contVisitID')
                ->select('appointmentinfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
                ->where('appointmentinfo.id', $id)
                ->first();
        } else if ($user->category == "Visitor") {
            $usertype = DB::table('appointmentinfo')
                ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
                ->join('visitorinfo', 'visitorinfo.userID', '=', 'appointmentinfo.contVisitID')
                ->select('appointmentinfo.*', 'users.*', 'visitorinfo.*', 'appointmentinfo.id as appointmentID')
                ->where('appointmentinfo.id', $id)
                ->first();
        }

        $biometric = DB::table('biometricinfo')
            ->select('biometricinfo.id as biometricID')
            ->where('userID', $id)
            ->exists();


        return view('biometric.scan_biometric', [
            'users' => $usertype,
            'userID' => $usertype->userID,
            'biometric' => $biometric,
            'source' => 'Contractor'
        ]);
    }

    public function findMatch()
    {

        return view('biometric.biometric');
    }

    public function fetchDataLabel()
    {
        // Fetch data from the database, assuming you have a 'your_table_name' table with a 'column_name' column

        $data = DB::table('users')
            ->join('biometricinfo', 'users.id', '=', 'biometricinfo.userID')
            ->select('users.name', 'biometricinfo.facialRecognition') // Replace 'column_name' with the actual column name from biometricInfo
            ->where('users.category', '=', 'Contractor')
            ->get();

        return response()->json($data);
    }

    public function nextButton($name)
    {
        $cleanedName = preg_replace('/\(\d+(\.\d+)?\)/', '', $name);
        $cleanedName = trim($cleanedName);

        $usertype = DB::table('users')
            ->where('name', $cleanedName)
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
            ->where('users.name', $cleanedName)
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
            ->where('users.name', $cleanedName)
            ->first();

        return view('profile.profile_registered', compact('usertype', 'visitor', 'contractor'));
    }

    public function getUserInformation($userID)
    {
        $user = DB::table('users')
            ->where('id', $userID)
            ->first();

        if ($user->category == "Contractor") {
            // Fetch the user's information from the database based on the provided name
            $usertype = DB::table('contractorinfo')
                ->join('users', 'users.id', '=', 'contractorinfo.userID')
                ->join('biometricinfo', 'biometricinfo.userID', '=', 'contractorinfo.userID')
                ->where('contractorinfo.userID', $userID)
                ->first();
        } elseif ($user->category == "Visitor") {
            $usertype = DB::table('visitorinfo')
                ->join('users', 'users.id', '=', 'visitorinfo.userID')
                ->join('biometricinfo', 'biometricinfo.userID', '=', 'visitorinfo.userID')
                ->where('visitorinfo.userID', $userID)
                ->first();
        }

        if (!$usertype) {
            return response()->json(['error' => 'Contractor information not found'], 404);
        }

        return response()->json($usertype);
    }
}
