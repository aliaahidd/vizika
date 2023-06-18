<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {

        if ($request->ajax()) {

            $klTime = Carbon::now('Asia/Kuala_Lumpur'); // Get current KL time
            $start = $klTime->toDateString(); // Get the date part in YYYY-MM-DD format

            $data = AppointmentInfo::select('id', 'appointmentPurpose as title', 'appointmentDate as start', 'appointmentTime')
                ->where('appointmentStatus', 'Attend')
                ->get()
                ->map(function ($event) {
                    $event->start = $event->start . 'T' . $event->appointmentTime;
                    return $event;
                });

            return response()->json($data);
        }

        return view('calendar.calendar');
    }

    public function calendarstaff(Request $request)
    {

        if ($request->ajax()) {

            $id = Auth::user()->id;
            $klTime = Carbon::now('Asia/Kuala_Lumpur'); // Get current KL time
            $start = $klTime->toDateString(); // Get the date part in YYYY-MM-DD format

            $data = AppointmentInfo::select('id', 'appointmentPurpose as title', 'appointmentDate as start', 'appointmentTime')
                ->where('appointmentStatus', 'Attend')
                ->where('staffID', $id)
                ->get()
                ->map(function ($event) {
                    $event->start = $event->start . 'T' . $event->appointmentTime;
                    return $event;
                });

            return response()->json($data);
        }

        return view('calendar.calendar');
    }
}
