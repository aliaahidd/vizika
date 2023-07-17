<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VisitorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BlacklistController extends Controller
{
    //visitor list 
    public function activeUser(Request $request)
    {
        $visitorlist = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->leftJoin('blacklistvisitor', function ($join) {
                $join->on('visitorinfo.userID', '=', 'blacklistvisitor.userID');
            })
            ->select([
                'users.id AS visitorID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*', 'companyinfo.*'
            ])
            ->whereNull('blacklistvisitor.userID')
            ->orderBy('visitorinfo.id', 'desc')
            ->get();

        $contractorlist = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->leftJoin('blacklistvisitor', function ($join) {
                $join->on('contractorinfo.userID', '=', 'blacklistvisitor.userID');
            })
            ->select([
                'users.id AS contractorID',
                'contractorinfo.id AS cID', 'users.*', 'contractorinfo.*', 'companyinfo.*'
            ])
            ->whereNull('blacklistvisitor.userID')
            ->orderBy('contractorinfo.id', 'desc')
            ->get();

        return view('blacklist.list_active', compact('visitorlist', 'contractorlist'));
    }

    //blacklist list 
    public function blacklistlist(Request $request)
    {

        $blacklistvisitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('blacklistvisitor', 'blacklistvisitor.userID', '=', 'visitorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'visitorinfo.companyID')
            ->select([
                'users.id AS visitorID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*', 'blacklistvisitor.*', 'companyinfo.*'
            ])
            ->orderBy('visitorinfo.id', 'desc')
            ->get();

        $blacklistcontractor = DB::table('contractorinfo')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('blacklistvisitor', 'blacklistvisitor.userID', '=', 'contractorinfo.userID')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->select([
                'users.id AS contractorID',
                'contractorinfo.id AS cID', 'users.*', 'contractorinfo.*', 'blacklistvisitor.*', 'companyinfo.*'
            ])
            ->orderBy('contractorinfo.id', 'desc')
            ->get();

        return view('blacklist.list_blacklist', compact('blacklistvisitor', 'blacklistcontractor'));
    }

    public function profilevisitor($id)
    {
        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS userID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $pastrecord = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'visitrecord.id as recordID')
            ->where('cont_visit_user.id', $id)
            ->orderBy('visitrecord.id', 'desc')
            ->get();

        return view('blacklist.profile_visitor', compact('visitor', 'pastrecord'));
    }

    public function profilecontractor($id)
    {
        $contractor = DB::table('contractorinfo')
            ->join('companyinfo', 'companyinfo.id', '=', 'contractorinfo.companyID')
            ->join('users', 'users.id', '=', 'contractorinfo.userID')
            ->join('biometricinfo', 'biometricinfo.userID', '=', 'users.id')
            ->select([
                'users.id AS userID',
                'contractorinfo.id AS cID', 'users.*', 'contractorinfo.*', 'companyinfo.*', 'biometricinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $pastrecord = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name', 'visitrecord.id as recordID')
            ->where('cont_visit_user.id', $id)
            ->orderBy('visitrecord.id', 'desc')
            ->get();

        return view('blacklist.profile_contractor', compact('contractor', 'pastrecord'));
    }

    //blacklist reason
    public function blacklist(Request $request, $id)
    {
        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Blacklisted';
        $userStatus->update();

        $blacklist = VisitorInfo::find($id);
        $blacklistReason = $request->input('blacklistReason');

        $data = array(
            'userID' => $id,
            'blacklistReason' => $blacklistReason,
        );

        // insert query
        DB::table('blacklistvisitor')->insert($data);


        return redirect()->route('userblacklist');
    }

    public function unblacklist($id)
    {
        $userStatus = User::where('id', $id)->first();
        $userStatus->status = 'Active';
        $userStatus->update();

        $blacklist = DB::table('blacklistvisitor')
            ->where('userID', $id)
            ->first();

        if ($blacklist) {
            // If the record exists, delete it
            DB::table('blacklistvisitor')
                ->where('userID', $id)
                ->delete();
        }

        return redirect()->route('useractive');
    }
}
