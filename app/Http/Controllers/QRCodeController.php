<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\VisitorQrScan;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;


class QRCodeController extends Controller
{

    public function qrcode()
    {
        return view('record.qr_code');
    }

    public function visitorform()
    {
        $companylist = DB::table('companyinfo')
            ->orderBy('companyName', 'asc')
            ->get();

        return view('record.visitor_form', compact('companylist'));
    }

    public function generateQrCode()
    {
        $url = $this->generateFormLink(); // Generate the form link

        $qrCode = new QrCode($url); // Create a new QR code instance
        $qrCode->setSize(300);
        $qrCode->setMargin(20);

        $imageData = $qrCode->writeString();

        $response = new Response($imageData);
        $response->headers->set('Content-Type', 'image/png');

        $qrCode->writeFile(public_path('assets/qr/qrcode.png'));

        return redirect()->route('qrcode');
    }
    

    private function generateFormLink()
    {
        // Generate your form link here (e.g., using a random token, unique identifier, etc.)
        return 'https://vizika.online/Visitor-Form';
    }

    public function storevisitorform(Request $request)
    {

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();
        $time_now = Carbon::now($kl_timezone)->toTimeString();

        $email = $request->input('email');

        // Check if the user ID already exists
        $existingEmail = DB::table('visitorqrscan')->where('email', $email)->first();

        if ($existingEmail) {

            $visitor = VisitorQrScan::where('email', $email)->first();

            $visitor->companyID = $request->input('companyID');
            $visitor->phoneNo = $request->input('phoneNo');
            $visitor->employeeNo = $request->input('employeeNo');
            $visitor->occupation = $request->input('occupation');
            $visitor->birthDate = $request->input('birthDate');
            $visitor->address = $request->input('address');

            // upadate query in the database
            $visitor->update();

            return redirect()->route('registerBiometric');
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $phonenumber = $request->input('phoneNo');
        $company = $request->input('companyName');
        $employeeNo = $request->input('employeeNo');
        $occupation = $request->input('occupation');
        $visitPurpose = $request->input('visitPurpose');

        $data = array(
            'name' => $name,
            'email' => $email,
            'phoneNo' => $phonenumber,
            'employeeNo' => $employeeNo,
            'companyName' => $company,
            'occupation' => $occupation,
            'visitPurpose' => $visitPurpose,
            'checkInDate' =>  $today_date,
            'checkInTime' =>  $time_now,
        );

        // insert query
        DB::table('visitorqrscan')->insert($data);

        return redirect()->route('registerBiometric');
    }
}
