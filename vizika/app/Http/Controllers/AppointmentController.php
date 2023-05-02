<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        //guard view

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $appointmentGuard = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users as cont_visit_user', 'appointmentInfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentInfo.staffID', '=', 'staff_user.id')
            ->select('appointmentInfo.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('appointmentDate', $today_date)
            ->where('appointmentStatus', 'Attend')
            ->get();

        return view('appointment.list_appointment', compact('appointmentVisitor', 'appointmentStaff', 'appointmentGuard'));
    }

    //choose visitor form page
    public function choosevisitorform(Request $request)
    {
        $visitorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Visitor')
            ->orwhere('category', 'Contractor')
            ->get();

        return view('appointment.choose_visitor', compact('visitorlist'));
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

    public function registervisitorform()
    {
        return view('appointment.register_visitor');
    }

    //register visitor (by staff)
    public function registervisitor(Request $request)
    {
        // create visitor account 
        // get user auth
        $name = $request->input('name');
        $email = $request->input('email');
        $category = $request->input('category');

        $Email = User::where('email', $email)->first();
        if ($Email) {
            return redirect()
                ->route('appointment/registervisitorform')
                ->with('message', 'Email is already exists.');
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
        return redirect()->route('choosevisitor');
    }

    //store appointment details
    public function storeappointment(Request $request)
    {
        if ($request->input('contractorName')) {
            // Contractor dropdown was selected
            $contVisit = $request->input('contractorName');
            // process data for contractor
        } elseif ($request->input('visitorName')) {
            // Visitor dropdown was selected
            $contVisit = $request->input('visitorName');
            // process data for visitor
        } 

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
}
