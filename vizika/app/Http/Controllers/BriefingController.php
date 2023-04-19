<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyBriefingInfo;

class BriefingController extends Controller
{
    public function briefing()
    {
        $briefinginfolist = DB::table('safetybriefinginfo')
            ->orderBy('id', 'desc')
            ->get();

        //check the expiry date pass for contractor
        $id = Auth::user()->id;

        $expirydatecontractor = DB::table('contractorinfo')
            ->where('id', $id)
            ->first();

        return view('briefing.list_briefing', compact('briefinginfolist'));
    }

    public function createbriefinginfo()
    {
        return view('briefing.create_briefing');
    }

    public function storebriefinginfo(Request $request)
    {
        // create briefing info
        $date = $request->input('briefingDate');
        $timeStart = $request->input('briefingTimeStart');
        $timeEnd = $request->input('briefingTimeEnd');
        $participant = $request->input('participantNo');


        $dateexist = SafetyBriefingInfo::where('briefingDate', $date)
            ->where('briefingTimeStart', $timeStart)
            ->first();
        if ($dateexist) {
            return redirect()
                ->route('briefing/createbriefinginfo')
                ->with('message', 'Session is already exists.');
        }

        $data = array(
            'briefingDate' => $date,
            'briefingTimeStart' => $timeStart,
            'briefingTimeEnd' => $timeEnd,
            'maxParticipant' => $participant,
        );

        // insert query
        DB::table('safetybriefinginfo')->insert($data);

        sleep(1);
        return redirect()->route('briefing');
    }
}
