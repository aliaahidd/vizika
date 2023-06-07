<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BiometricInfo;
use App\Models\ContractorInfo;

class BiometricController extends Controller
{
    public function facialRecog()
    {
        return view('biometric.biometric');
    }

    public function registerBiometric($id)
    {

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
        $userID = $request->input('userId'); // Retrieve the userID from the request body

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

        return redirect()->route('choosevisitor');

        return response()->json(['message' => 'Image saved successfully']);
    }

    public function scanBiometric($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        if ($user->category == "Contractor") {
            $usertype = DB::table('appointmentinfo')
                ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
                ->join('contractorinfo', 'contractorinfo.userID', '=', 'appointmentinfo.contVisitID')
                ->select('appointmentInfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
                ->where('contVisitID', $id)
                ->first();
        } else if ($user->category == "Visitor") {
            $usertype = DB::table('appointmentinfo')
                ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
                ->join('visitorinfo', 'visitorinfo.userID', '=', 'appointmentinfo.contVisitID')
                ->select('appointmentInfo.*', 'users.*', 'visitorinfo.*', 'appointmentinfo.id as appointmentID')
                ->where('contVisitID', $id)
                ->first();
        }

        $biometric = DB::table('biometricinfo')
            ->select('biometricinfo.id as biometricID')
            ->where('userID', $id)
            ->exists();

        // Retrieve stored image paths from the database
        $storedImagePaths = DB::table('biometricinfo')->pluck('facialRecognition');

        return view('biometric.scan_biometric', [
            'contractor' => $usertype,
            'userID' => $usertype->userID,
            'biometric' => $biometric,
            'storedImagePaths' => $storedImagePaths,
            'source' => 'Contractor'
        ]);
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
