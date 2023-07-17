<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;

class QRCodeController extends Controller
{
    
    public function generateQrCode()
    {
        $url = $this->generateFormLink(); // Generate the form link

        $qrCode = new QrCode($url); // Create a new QR code instance
        $qrCode->setSize(300); // Set the size of the QR code

        return response($qrCode->writeString(), 200, [
            'Content-Type' => $qrCode->getContentType()
        ]); // Return the QR code image as a response
    }

    private function generateFormLink()
    {
        // Generate your form link here (e.g., using a random token, unique identifier, etc.)
        return 'https://kalam.ump.edu.my/login/index.php';
    }
}
