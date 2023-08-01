<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TransportController extends Controller
{
    public function transport()
    {
        $transportList = DB::table('transport')
            ->join('companyinfo', 'companyinfo.id', '=', 'transport.companyID')
            ->select([
                'companyinfo.id AS companyID',
                'transport.id AS transportID', 'transport.*', 'companyinfo.*'
            ])
            ->orderBy('transportID', 'desc')
            ->get();

        return view('transport.list_transport', compact('transportList'));
    }

    public function registerTransport()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        $contractorlist = DB::table('users')
            ->orderBy('name', 'asc')
            ->where('category', 'Contractor')
            ->get();

        return view('transport.register_transport', compact('companylist', 'contractorlist'));
    }

    public function storetransportregistration(Request $request)
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        // store inspection
        $date = $request->input('visitDate');
        $companyID = $request->input('companyID');
        $vehicleRegNo = $request->input('vehicleRegNo');

        // Retrieve selected contractor IDs and split them using the delimiter "/"
        $selectedContractorIDs = explode('/', $request->input('selectedContractorIDs'));
        $contractorID = json_encode($selectedContractorIDs);

        $data = array(
            'visitDate' => $date,
            'companyID' => $companyID,
            'vehicleRegNo' => $vehicleRegNo,
            'contractorID' => $contractorID, // Convert the contractor IDs to JSON and store it in the database
            'plant' => 'Painting', 
            'passNo' => '123', 
            'checkInTime' => $time_now, 
        );

        // insert query
        DB::table('transportinspection')->insert($data);

        return redirect()->route('transportInspection');
    }

    public function transportInspection()
    {
        $inspectionList = DB::table('transportinspection')
            ->join('companyinfo', 'companyinfo.id', '=', 'transportinspection.companyID')
            ->select([
                'companyinfo.id AS companyID',
                'transportinspection.id AS inspectionID', 'transportinspection.*', 'companyinfo.*'
            ])
            ->orderBy('inspectionID', 'desc')
            ->get();

        return view('transport.list_inspection', compact('inspectionList'));
    }

    public function inspectionform()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('transport.inspection_form', compact('companylist'));
    }

    public function storeinspection(Request $request)
    {
        // store inspection
        $date = $request->input('visitDate');
        $companyID = $request->input('companyID');
        $vehicleRegNo = $request->input('vehicleRegNo');
        $security = $request->input('security');
        // Retrieve the checkbox values from the request
        $primeMoverInside = $request->input('primeMoverInside', false);
        $primeMoverBack = $request->input('primeMoverBack', false);
        $trailerUnder = $request->input('trailerUnder', false);
        $trailerBehind = $request->input('trailerBehind', false);
        $trailerLeft = $request->input('trailerLeft', false);
        $trailerRight = $request->input('trailerRight', false);

        $data = array(
            'companyID' => $companyID,
            'visitDate' => $date,
            'vehicleRegNo' => $vehicleRegNo,
            'primeMoverInside' => $primeMoverInside,
            'primeMoverBack' => $primeMoverBack,
            'trailerUnder' => $trailerUnder,
            'trailerBehind' => $trailerBehind,
            'trailerLeft' => $trailerLeft,
            'trailerRight' => $trailerRight,
            'security' => $security,
        );

        // insert query
        DB::table('transportinspection')->insert($data);

        return redirect()->route('transportInspection');
    }
}
