<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use App\Models\AppointmentInfo;
use App\Models\User;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // list of appointment for all users    
    public function appointment()
    {
        //staff view 
        $appointmentStaff = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'appointmentinfo.contVisitID')
            ->select([
                'users.id AS staffID',
                'appointmentinfo.id AS appointmentID', 'users.*', 'appointmentinfo.*'
            ])
            ->where('staffID', Auth::user()->id)
            ->get();

        //visitor view
        $appointmentVisitor = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'appointmentinfo.staffID')
            ->select([
                'users.id AS staffID',
                'appointmentinfo.id AS appointmentID', 'users.*', 'appointmentinfo.*'
            ])
            ->where('contVisitID', Auth::user()->id)
            ->get();

        return view('appointment.list_appointment', compact('appointmentVisitor', 'appointmentStaff'));
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
            ->select('appointmentinfo.*', 'appointmentinfo.id as appointmentID', 'cont_visit_user.*', 'cont_visit_user.id as contVisitID', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'biometricinfo.userID')
            ->where('appointmentDate', $today_date)
            ->where('appointmentStatus', 'Attend')
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

    //create appointment form page
    public function createappointmentformold(Request $request)
    {
        $visitorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Visitor')
            ->get();

        $contractorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Contractor')
            ->get();

        return view('appointment.create_appointment_old', compact('visitorlist', 'contractorlist'));
    }

    //store appointment details
    public function storeappointment(Request $request)
    {
        if ($request->input('userType') == 'Contractor') {
            // Contractor dropdown was selected
            $contVisit = $request->input('contractorName');
            // process data for contractor
        } elseif ($request->input('userType') == 'Visitor') {
            // Visitor dropdown was selected
            $contVisit = $request->input('visitorName');
            // process data for visitor
        }

        dd($contVisit);

        $dataquery = array(
            'staffID'             =>  Auth::user()->id,
            'contVisitID'         =>  $contVisit,
            'appointmentPurpose'  =>  $request->appointmentPurpose,
            'appointmentAgenda'   =>  $request->appointmentAgenda,
            'appointmentDate'     =>  $request->appointmentDate,
            'appointmentTime'     =>  $request->appointmentTime,
            'appointmentStatus'   =>  'Pending',
        );
        // insert query appointment
        DB::table('appointmentinfo')->insert($dataquery);

        $user = DB::table('users')
            ->select([
                'name', 'email',
            ])
            ->where('users.id', $contVisit)
            ->first();

        //send email
        $this->validate($request, [
            'appointmentPurpose'  =>  'required',
            'appointmentAgenda'   =>  'required',
            'appointmentDate'     =>  'required',
            'appointmentTime'     =>  'required',
        ]);

        $data = array(
            'name'                =>  $user->name,
            'email'               =>  $user->email,
            'appointmentPurpose'  =>  $request->appointmentPurpose,
            'appointmentAgenda'   =>  $request->appointmentAgenda,
            'appointmentDate'     =>  $request->appointmentDate,
            'appointmentTime'     =>  $request->appointmentTime
        );

        $to = [
            [
                'email' => $user->email,
            ]
        ];

        //send email 
        Mail::to($to)->send(new SendEmail($data));
        return back()->with('success', 'Email sent.');
    }

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
            ->select('appointmentInfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
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
            ->select('appointmentinfo.*', 'users.*', 'visitorinfo.*', 'appointmentinfo.id as appointmentID')
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
            ->select('appointmentInfo.*', 'users.*', 'contractorinfo.*', 'appointmentinfo.id as appointmentID')
            ->where('appointmentinfo.id', $id)
            ->first();

        return view('appointment.today_appointment', [
            'usertype' => $contractor,
            'source' => 'contractor'
        ]);
    }
}
