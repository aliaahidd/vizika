<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyBriefingInfo;
use Carbon\Carbon;

class BriefingController extends Controller
{
    public function briefing()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        if (Auth::user()->category == 'Contractor') {

            //check the expiry date pass for contractor
            $validitypasscheck = DB::table('contractorinfo')
                ->where('userID', Auth::user()->id)
                ->where('passExpiryDate', '<', $today_date)
                ->first();

            if ($validitypasscheck) {
                $alreadyenroll = DB::table('briefingsession')
                    ->where('contractorID', Auth::user()->id)
                    ->first();

                if ($alreadyenroll) {
                    $briefingenrollmentdetails = DB::table('briefingsession')
                        ->join('safetybriefinginfo', 'safetybriefinginfo.id', '=', 'briefingsession.briefingID')
                        ->where('briefingsession.contractorID', Auth::user()->id)
                        ->get();

                    return view('briefing.list_briefing', compact('alreadyenroll', 'briefingenrollmentdetails'));
                } else {

                    $briefinginfolist = DB::table('safetybriefinginfo')
                        ->orderBy('id', 'desc')
                        ->get();

                        foreach ($briefinginfolist as $briefingInfo) {
                            $enrollmentOpen = true;
                        
                            $totalParticipant = DB::table('briefingsession')
                                ->where('briefingID', $briefingInfo->id)
                                ->distinct('contractorID')
                                ->count('contractorID');
                        
                            if ($totalParticipant >= $briefingInfo->maxParticipant) {
                                $enrollmentOpen = false;
                            }
                        
                            $briefingInfo->totalParticipants = $totalParticipant;
                            $briefingInfo->enrollmentOpen = $enrollmentOpen;
                        }

                    return view('briefing.list_briefing', compact('briefinginfolist', 'totalParticipant', 'alreadyenroll'));
                }
            }

            return redirect()->back()->with('success', 'Sorry, you do not have permission to enroll');
        } else if (Auth::user()->category == 'SHEQ Officer') {
            $briefinginfolist = DB::table('safetybriefinginfo')
                ->orderBy('id', 'desc')
                ->get();

            //count total current participants foe each session 
            $totalParticipant = DB::table('briefingsession')
                ->select('briefingID', DB::raw('count(DISTINCT contractorID) as totalParticipants'))
                ->groupBy('briefingID')
                ->get();

            return view('briefing.list_briefing', compact('briefinginfolist', 'totalParticipant'));
        }
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

    public function enrollbriefing($id)
    {
        //check the expiry date pass for contractor
        $userID = Auth::user()->id;

        $data = array(
            'briefingID' => $id,
            'contractorID' => $userID,
            'totalParticipant' => 0,
        );

        // insert query
        DB::table('briefingsession')->insert($data);

        sleep(1);
        return redirect()->route('briefing');
    }
}
