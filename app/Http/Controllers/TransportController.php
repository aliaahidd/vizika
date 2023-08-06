<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Transport;


class TransportController extends Controller
{
    public function contractortransport()
    {
        $transportList = DB::table('transport')
            ->join('companyinfo', 'companyinfo.id', '=', 'transport.companyID')
            ->select([
                'transport.checkInTime', 'companyinfo.companyName', 'transport.vehicleRegNo', 'transport.visitDate', 'transport.checkOutTime',
                DB::raw('COUNT(transport.id) AS totalTransport'),
                DB::raw('COUNT(companyinfo.id) AS totalCompanyInfo'),
                DB::raw('MAX(transport.id) AS transportID')
            ])
            ->groupBy('transport.checkInTime', 'companyinfo.companyName', 'transport.vehicleRegNo', 'transport.visitDate', 'transport.checkOutTime')
            ->orderBy('transport.id', 'desc')
            ->get();


        return view('transport.list_transport', compact('transportList'));
    }

    public function contractortransportdetails($id)
    {
        $transportInfo = DB::table('transport')
            ->join('companyinfo', 'companyinfo.id', '=', 'transport.companyID')
            ->where('transport.id', '=', $id)
            ->first();

        $contractorInfo = DB::table('transport')
            ->join('users', 'users.id', '=', 'transport.contractorID')
            ->where('transport.checkInTime', '=', $transportInfo->checkInTime)
            ->get();

        return view('transport.contractor_transport_details', compact('transportInfo', 'contractorInfo'));
    }

    public function checkoutTransport($id)
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        // Find the record by id
        $checkoutInfo = Transport::find($id);

        // If the record exists, get the checkInTime value
        if ($checkoutInfo) {
            $checkInTime = $checkoutInfo->checkInTime;
            $vehicleRegNo = $checkoutInfo->vehicleRegNo;

            // Find all records with the same checkInTime and update their checkOutTime
            Transport::where('checkInTime', $checkInTime)
                ->where('vehicleRegNo', $vehicleRegNo)
                ->update(['checkOutTime' => $time_now]);

            // Display message box in the same page
            return redirect()->back()->with('message', 'Checkout updated');
        }

        // If the record with the given id does not exist, redirect back with an error message
        return redirect()->back()->with('error', 'Record not found');
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

        // Store inspection details
        $date = $request->input('visitDate');
        $companyID = $request->input('companyID');
        $vehicleRegNo = $request->input('vehicleRegNo');

        // Retrieve selected contractor IDs and split them using the delimiter "/"
        $contractorIDs = $request->input('contractorID');

        // Loop through each contractor ID and save the records
        foreach ($contractorIDs as $index => $contractorID) {
            $noIC = $request->input('noIC')[$index];
            $plant = $request->input('plant')[$index];
            $passNo = $request->input('passNo')[$index];

            $data = array(
                'visitDate' => $date,
                'companyID' => $companyID,
                'vehicleRegNo' => $vehicleRegNo,
                'contractorID' => $contractorID,
                'noIC' => $noIC,
                'plant' => $plant,
                'passNo' => $passNo,
                'checkInTime' => $time_now,
            );

            // insert query
            DB::table('transport')->insert($data);
        }

        return redirect()->route('contractortransport');
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

    public function transportvehicle()
    {
        $vehicleList = DB::table('vehicle')
            ->join('companyinfo', 'companyinfo.id', '=', 'vehicle.companyID')
            ->select([
                'companyinfo.id AS companyID',
                'vehicle.id AS vehicleID', 'vehicle.*', 'companyinfo.*'
            ])
            ->orderBy('vehicleID', 'desc')
            ->get();

        return view('transport.list_vehicle', compact('vehicleList'));
    }

    public function registerVehicle()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('transport.register_vehicle', compact('companylist'));
    }

    public function storevehicleregistration(Request $request)
    {
        // store vehicle
        $companyID = $request->input('companyID');
        $vehicleRegNo = $request->input('vehicleRegNo');
        $vehicleType = $request->input('vehicleType');
        $vehicleCC = $request->input('vehicleCC');
        $vehicleColour = $request->input('vehicleColour');
        $vehicleWeight = $request->input('vehicleWeight');

        $data = array(
            'vehicleRegNo' => $vehicleRegNo,
            'vehicleType' => $vehicleType,
            'vehicleCC' => $vehicleCC,
            'vehicleColour' => $vehicleColour,
            'vehicleWeight' => $vehicleWeight,
            'companyID' => $companyID,
        );

        // insert query
        DB::table('vehicle')->insert($data);

        return redirect()->route('transportvehicle');
    }
}
