<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppointmentInfo;
use Carbon\Carbon;


class CalendarController extends Controller
{
    public function calendar(Request $request)
    {

        if ($request->ajax()) {

            $klTime = Carbon::now('Asia/Kuala_Lumpur'); // Get current KL time
            $start = $klTime->toDateString(); // Get the date part in YYYY-MM-DD format

            $data = AppointmentInfo::select('id', 'appointmentPurpose as title', 'appointmentDate as start', 'appointmentTime')
                ->get()
                ->map(function ($event) {
                    $event->start = $event->start . 'T' . $event->appointmentTime;
                    return $event;
                });

            return response()->json($data);
        }

        return view('Calendar.calendar');
    }
}
