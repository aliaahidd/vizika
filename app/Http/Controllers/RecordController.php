<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VisitRecord;
use App\Models\AppointmentInfo;
use App\Models\User;
use App\Models\VisitorQrScan;
use Carbon\Carbon;

class RecordController extends Controller
{
    //past record display table
    public function record()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $id = Auth::user()->id;

        $recordliststaff = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'appointmentinfo.*')
            ->where('appointmentinfo.staffID', $id)
            ->orderBy('visitrecord.id', 'desc')
            ->get();

        return view('record.list_record', compact('recordliststaff'));
    }

    public function historyappointment()
    {
        $historyappointment = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'appointmentinfo.*')
            ->whereNotNull('checkOutDate')
            ->get();

        return view('record.past_appointment', compact('historyappointment'));
    }

    public function checkinuser(Request $request, $id)
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        // request pass number from ajax
        $passNumber = $request->input('passNo');

        $dataquery = array(
            'appointmentID'         =>  $id,
            'passNo'              =>  $passNumber,
            'checkInDate'         =>  $today_date,
            'checkInTime'         =>  $time_now,
        );
        // insert query appointment
        DB::table('visitrecord')->insert($dataquery);

        return redirect()->route('dashboardGuard');
    }

    // public function checkincontractor(Request $request, $id)
    // {
    //     // Set the timezone to Kuala Lumpur
    //     $kl_timezone = 'Asia/Kuala_Lumpur';

    //     // Get today's date in Kuala Lumpur timezone
    //     $today_date = Carbon::now($kl_timezone)->toDateString();
    //     $time_now = Carbon::now($kl_timezone)->toTimeString();

    //     //request pass number from ajax
    //     $passNumber = $request->input('passNoC');

    //     $dataquery = array(
    //         'appointmentID'       =>  $id,
    //         'passNo'              =>  $passNumber,
    //         'checkInDate'         =>  $today_date,
    //         'checkInTime'         =>  $time_now,
    //     );
    //     // insert query appointment
    //     DB::table('visitrecord')->insert($dataquery);

    //     return redirect()->route('dashboardGuard');
    // }

    public function checkout($id)
    {
        $checkoutinfo = VisitRecord::find($id);

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        $checkoutinfo->checkOutDate = $today_date;
        $checkoutinfo->checkOutTime = $time_now;

        $checkoutinfo->update();

        // display message box in the same page
        return redirect()->back()->with('message', 'Checkout updated');
    }

    //past record display table
    public function visitorlog()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $visitorlog = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'visitrecord.id as recordID', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('checkInDate', $today_date)
            ->orderBy('visitrecord.id', 'desc')
            ->get();

        return view('record.visitorlog', compact('visitorlog'));
    }

    //past record display table for user scan qr code
    public function visitorlogqrcode()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $visitorlog = DB::table('visitorqrscan')
            ->where('checkInDate', $today_date)
            ->orderBy('id', 'desc')
            ->get();

        return view('record.visitorlogscanqr', compact('visitorlog'));
    }

    //checkout qr scan
    public function checkoutQR($id)
    {
        $checkoutinfo = VisitorQrScan::find($id);

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        $checkoutinfo->checkOutDate = $today_date;
        $checkoutinfo->checkOutTime = $time_now;

        $checkoutinfo->update();

        // display message box in the same page
        return redirect()->back()->with('message', 'Checkout updated');
    }
}
