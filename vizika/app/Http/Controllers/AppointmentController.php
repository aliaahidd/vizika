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

class AppointmentController extends Controller
{
    // list of appointment for all users    
    public function appointment()
    {
        $appointmentStaff = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'appointmentinfo.visitorID')
            ->where('staffID', Auth::user()->id)
            ->get();

        $appointmentVisitor = DB::table('appointmentinfo')
            ->orderBy('appointmentinfo.id', 'desc')
            ->join('users', 'users.id', '=', 'appointmentinfo.staffID')
            ->where('visitorID', Auth::user()->id)
            ->get();
        return view('appointment.list_appointment', compact('appointmentVisitor', 'appointmentStaff'));
    }

    //choose visitor form page
    public function choosevisitorform(Request $request)
    {
        $visitorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Visitor')
            ->get();

        return view('appointment.choose_visitor', compact('visitorlist'));
    }

    //create appointment form page
    public function createappointmentform(Request $request, $id)
    {
        $appointment = User::find($id);

        return view('appointment.create_appointment', compact('appointment'));
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
            'category' => 'Visitor',
        );

        // insert query
        DB::table('users')->insert($data);

        sleep(1);
        return redirect()->route('appointment/choosevisitor');
    }

    //store appointment details
    public function storeappointment(Request $request, $id)
    {
        $dataquery = array(
            'staffID'             =>  Auth::user()->id,
            'visitorID'           =>  $id,
            'appointmentName'     =>  $request->appointmentName,
            'appointmentDate'     =>  $request->appointmentDate,
            'appointmentTime'     =>  $request->appointmentTime,
            'appointmentPurpose'  =>  $request->appointmentPurpose,
        );
        // insert query appointment
        DB::table('appointmentinfo')->insert($dataquery);

        //send email
        $this->validate($request, [
            'name'                =>  'required',
            'appointmentName'     =>  'required',
            'appointmentDate'     =>  'required',
            'appointmentTime'     =>  'required',
            'email'               =>  'required|email',
            'appointmentPurpose'  =>  'required'
        ]);

        $data = array(
            'name'                =>  $request->name,
            'appointmentName'     =>  $request->appointmentName,
            'appointmentDate'     =>  $request->appointmentDate,
            'appointmentTime'     =>  $request->appointmentTime,
            'appointmentPurpose'  =>  $request->appointmentPurpose,
            'email'               =>  $request->email
        );

        $to = [
            [
                'email' => $request->email,
            ]
        ];

        //send email 
        Mail::to($to)->send(new SendEmail($data));
        return back()->with('success', 'Email sent.');
    }
}
