<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use App\Models\AppointmentInfo;
use App\Models\LaptopInfo;
use App\Models\User;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // list of appointment for all users    
    public function appointment()
    {
        //staff view 
        $appointmentStaff = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->leftJoin('laptopinfo', 'laptopinfo.appointmentID', '=', 'appointmentinfo.id')
            ->select([
                'users.id AS staffID',
                'appointmentinfo.id AS appointID', 'users.*', 'appointmentinfo.*', 'laptopinfo.*'
            ])
            ->where('staffID', Auth::user()->id)
            ->orderBy('appointmentinfo.id', 'desc')
            ->get();

        //visitor view
        $appointmentVisitor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.staffID')
            ->leftJoin('laptopinfo', 'laptopinfo.appointmentID', '=', 'appointmentinfo.id')
            ->select([
                'users.id AS staffID',
                'appointmentinfo.id AS appointID', 'users.*', 'appointmentinfo.*', 'laptopinfo.*'
            ])
            ->where('contVisitID', Auth::user()->id)
            ->orderBy('appointmentinfo.id', 'desc')
            ->get();

        return view('appointment.list_appointment', compact('appointmentVisitor', 'appointmentStaff'));
    }

    // list of appointment for all users    
    public function appointmentdetails($id)
    {

        $laptopExist = DB::table('laptopinfo')
            ->where('appointmentID', $id)
            ->exists();

        $laptopinfo = DB::table('laptopinfo')
            ->where('appointmentID', $id)
            ->first();

        $vehicleExist = DB::table('vehicleinfo')
            ->where('appointmentID', $id)
            ->exists();

        $vehicleinfo = DB::table('vehicleinfo')
            ->where('appointmentID', $id)
            ->first();

        //visitor view
        $appointmentVisitor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.staffID')
            ->select([
                'users.id AS staffID',
                'appointmentinfo.id AS appointmentID', 'users.*', 'appointmentinfo.*'
            ])
            ->where('contVisitID', Auth::user()->id)
            ->orderBy('appointmentinfo.id', 'desc')
            ->first();

        return view('appointment.appointment_details', compact('appointmentVisitor', 'laptopExist', 'laptopinfo', 'vehicleExist', 'vehicleinfo'));
    }

    // list of appointment for all users    
    public function appointmenttoday()
    {
        //guard view

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $appointmentGuard = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->leftJoin('biometricinfo', 'biometricinfo.userID', '=', 'cont_visit_user.id')
            ->leftJoin('visitrecord', 'visitrecord.appointmentID', '=', 'appointmentinfo.id')
            ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'biometricinfo.userID')
            ->where('appointmentDate', $today_date)
            ->where('appointmentStatus', 'Attend')
            ->whereNull('visitrecord.appointmentID') // Filter only records not existing in visitrecord
            ->get();

        return view('appointment.list_today_appointment', compact('appointmentGuard'));
    }

    //create appointment form page
    public function createappointmentform(Request $request)
    {
        $visitorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Visitor')
            ->get();

        $contractorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Contractor')
            ->get();

        return view('appointment.create_appointment', compact('visitorlist', 'contractorlist'));
    }

    //store appointment with send email 
    public function storeappointmentmultiple(Request $request)
    {
        $appointments = $request->input('appointments');
        $successCount = 0;

        foreach ($appointments as $user) {
            $contVisitID = $user['contVisitID'];
            $appointmentDate = $user['appointmentDate'];
            $appointmentTime = $user['appointmentTime'];
            $appointmentPurpose = $user['appointmentPurpose'];
            $appointmentAgenda = $user['appointmentAgenda'];

            // Create a new appointment record in the database
            $appointment = new AppointmentInfo();
            $appointment->staffID = Auth::user()->id;
            $appointment->contVisitID = $contVisitID;
            $appointment->appointmentPurpose = $appointmentPurpose;
            $appointment->appointmentAgenda = $appointmentAgenda;
            $appointment->appointmentDate = $appointmentDate;
            $appointment->appointmentTime = $appointmentTime;
            $appointment->appointmentStatus = 'Pending';
            $appointment->bringVehicle = 'No';
            $appointment->bringLaptop = 'No';
            $appointment->save();
            $successCount++;

            $contVisit = DB::table('users')
                ->select([
                    'name', 'email',
                ])
                ->where('users.id', $contVisitID)
                ->first();

            //send email

            $data = array(
                'name'                =>  $contVisit->name,
                'email'               =>  $contVisit->email,
                'appointmentPurpose'  =>  $appointmentPurpose,
                'appointmentAgenda'   =>  $appointmentAgenda,
                'appointmentDate'     =>  $appointmentDate,
                'appointmentTime'     =>  $appointmentTime
            );

            $to = [
                [
                    'email' => $contVisit->email,
                ]
            ];

            //send email 
            Mail::to($to)->send(new SendEmail($data));
        }

        if ($successCount > 0) {
            $response = [
                'success' => true,
                'message' => 'Appointments created successfully.',
                'redirect' => route('appointment'),

            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Failed to create appointments.',
                'redirect' => null,

            ];
        }

        return response()->json($response);
    }

    //laptop infor store
    public function laptopinfo(Request $request, $id)
    {
        $bringLaptop = AppointmentInfo::find($id);
        $bringLaptop->bringLaptop = "Yes";

        $bringLaptop->update();

        $laptopBrand = $request->input('laptopBrand');
        $laptopModel = $request->input('laptopModel');
        $laptopColor = $request->input('laptopColor');
        $laptopSerialNo = $request->input('laptopSerialNo');

        $data = array(
            'appointmentID' => $id,
            'laptopBrand' => $laptopBrand,
            'laptopModel' => $laptopModel,
            'laptopColor' => $laptopColor,
            'laptopSerialNo' => $laptopSerialNo,
            'status' => 'Pending',
        );

        // insert query
        DB::table('laptopinfo')->insert($data);

        return redirect()->route('appointmentdetails', ['id' => $id]);
    }

    //vehicle infor store
    public function vehicleinfo(Request $request, $id)
    {
        $bringVehicle = AppointmentInfo::find($id);
        $bringVehicle->bringVehicle = "Yes";

        $bringVehicle->update();

        $vehicleType = $request->input('vehicleType');
        $vehicleBrand = $request->input('vehicleBrand');
        $vehicleColor = $request->input('vehicleColor');
        $vehicleRegNo = $request->input('vehicleRegNo');

        $data = array(
            'appointmentID' => $id,
            'vehicleType' => $vehicleType,
            'vehicleBrand' => $vehicleBrand,
            'vehicleColor' => $vehicleColor,
            'vehicleRegNo' => $vehicleRegNo,
        );

        // insert query
        DB::table('vehicleinfo')->insert($data);

        return redirect()->route('appointmentdetails', ['id' => $id]);
    }

    //function for visitor to attend 
    public function attendvisit($id)
    {
        $visit = AppointmentInfo::find($id);
        $visit->appointmentStatus = "Attend";

        $visit->update();
        return redirect()->route('appointment');
    }

    //function for visitor to attend 
    public function notattendvisit($id)
    {
        $visit = AppointmentInfo::find($id);
        $visit->appointmentStatus = "Not Attend";

        $visit->update();
        return redirect()->route('appointment');
    }

    //function for visitor to attend 
    public function approveLaptop($id)
    {
        $approve = LaptopInfo::find($id);
        $approve->status = "Approved";

        $approve->update();
        return redirect()->route('appointment');
    }

    //function for visitor to attend 
    public function rejectLaptop($id)
    {
        $reject = LaptopInfo::find($id);
        $reject->status = "Rejected";

        $reject->update();
        return redirect()->route('appointment');
    }

    //modal visitor 
    public function modalVisitor($id)
    {
        $visitor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->join('visitorinfo', 'visitorinfo.userID', '=', 'appointmentinfo.contVisitID')
            ->select('appointmentinfo.*', 'users.*', 'visitorinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('contVisitID', $id)
            ->first();
        return response()->json($visitor);
    }

    //modal contractor
    public function modalContractor($id)
    {
        $visitor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->join('contractorinfo', 'contractorinfo.userID', '=', 'appointmentinfo.contVisitID')
            ->select('appointmentinfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('contVisitID', $id)
            ->first();
        return response()->json($visitor);
    }

    // visitor 
    public function todayAppointmentVisitor($id)
    {
        $visitor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->join('visitorinfo', 'visitorinfo.userID', '=', 'appointmentinfo.contVisitID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->select('appointmentinfo.*', 'users.*', 'visitorinfo.*', 'companyinfo.*', 'biometricinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('appointmentinfo.id', $id)
            ->first();

        return view('appointment.today_appointment', [
            'usertype' => $visitor,
            'source' => 'visitor'
        ]);
    }

    // contractor
    public function todayAppointmentContractor($id)
    {
        $contractor = DB::table('appointmentinfo')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->join('contractorinfo', 'contractorinfo.userID', '=', 'appointmentinfo.contVisitID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->select('appointmentinfo.*', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('appointmentinfo.id', $id)
            ->first();

        return view('appointment.today_appointment', [
            'usertype' => $contractor,
            'source' => 'contractor'
        ]);
    }
}
