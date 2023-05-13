<?php

namespace App\Http\Controllers;

use App\Models\VisitorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BlacklistController extends Controller
{
    //visitor list 
    public function visitor(Request $request)
    {
        $visitorlist = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->leftJoin('blacklistvisitor', function ($join) {
                $join->on('visitorinfo.userID', '=', 'blacklistvisitor.visitorID');
            })
            ->select([
                'users.id AS visitorID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*'
            ])
            ->whereNull('blacklistvisitor.visitorID')
            ->orderBy('visitorinfo.id', 'desc')
            ->get();

        return view('blacklist.list_visitor', compact('visitorlist'));
    }

    //blacklist list 
    public function blacklistlist(Request $request)
    {
        $blacklistlist = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->join('blacklistvisitor', 'blacklistvisitor.visitorID', '=', 'visitorinfo.userID')
            ->select([
                'users.id AS visitorID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*', 'blacklistvisitor.*'
            ])
            ->orderBy('visitorinfo.id', 'desc')
            ->get();

        return view('blacklist.list_blacklist', compact('blacklistlist'));
    }

    public function profilevisitor($id)
    {
        $visitor = DB::table('visitorinfo')
            ->join('users', 'users.id', '=', 'visitorinfo.userID')
            ->select([
                'users.id AS userID',
                'visitorinfo.id AS vID', 'users.*', 'visitorinfo.*'
            ])
            ->where('users.id', $id)
            ->first();

        $pastrecord = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('users as cont_visit_user', 'visitrecord.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'visitrecord.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->where('cont_visit_user.id', $id)
            ->get();

        return view('blacklist.profile_visitor', compact('visitor', 'pastrecord'));
    }

    //blacklist reason
    public function blacklist(Request $request, $id)
    {
        $blacklist = VisitorInfo::find($id);
        $blacklistReason = $request->input('blacklistReason');

        $data = array(
            'visitorID' => $id,
            'blacklistReason' => $blacklistReason,
        );

        // insert query
        DB::table('blacklistvisitor')->insert($data);


        return redirect()->route('visitor');
    }
}
