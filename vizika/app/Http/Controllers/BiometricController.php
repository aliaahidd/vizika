<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BiometricInfo;

class BiometricController extends Controller
{
    public function facialRecog()
    {
        return view('biometric.biometric');
    }

    public function registerBiometric($id)
    {

        $contractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->where('users.id', $id)
            ->first();

        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->where('users.id', $id)
            ->first();

        return view('biometric.register_biometric', compact('contractor', 'visitor'));
    }

    public function saveImage(Request $request)
    {
        $userID = $request->input('userId'); // Retrieve the userID from the request body

        $imageData = $request->input('image');

        // Generate a unique file name
        $fileName = uniqid() . '.jpg';

        // Save the image file in the assets directory
        $path = 'assets/biometric/' . $fileName;
        file_put_contents(public_path($path), base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData)));

        // Save the file name (path) to the database
        $image = new BiometricInfo();
        $image->userID = $userID;
        $image->facialRecognition = $path;
        $image->save();

        return redirect()->route('choosevisitor');

        return response()->json(['message' => 'Image saved successfully']);
    }

    public function scanBiometric($id)
    {
        $contractor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->join('contractorinfo', 'contractorinfo.userID', '=', 'appointmentinfo.contVisitID')
            ->select('appointmentInfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('contVisitID', $id)
            ->first();

        $biometric = DB::table('biometricinfo')
            ->select('biometricinfo.id as biometricID')
            ->where('userID', $id)
            ->exists();

        // Retrieve stored image paths from the database
        $storedImagePaths = DB::table('biometricinfo')->pluck('facialRecognition');

        return view('biometric.scan_biometric', [
            'contractor' => $contractor,
            'biometric' => $biometric,
            'storedImagePaths' => $storedImagePaths,
            'source' => 'Contractor'
        ]);
    }
}
