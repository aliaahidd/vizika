<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SafetyBriefingInfo;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;


class ReportController extends Controller
{
    public function report()
    {
        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $data = 'AllReport';

        $reportlist = DB::table('visitrecord')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->whereNotNull('visitrecord.checkOutDate')
            ->orderBy('visitrecord.id', 'desc')
            ->get();

        return view('report.list_report', compact('reportlist'))->with('data', $data)->with('exportData', true);
    }

    public function generatereport(Request $request)
    {
        //request input from form 
        $dateStart = $request->input('dateStart');
        $dateEnd = $request->input('dateEnd');

        // Set the timezone to Kuala Lumpur
        $kl_timezone = 'Asia/Kuala_Lumpur';

        // Get today's date in Kuala Lumpur timezone
        $today_date = Carbon::now($kl_timezone)->toDateString();

        $data = 'GeneratedReport';

        $reportlist = DB::table('visitrecord')
            ->orderBy('visitrecord.id', 'desc')
            ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
            ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
            ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
            ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
            ->whereBetween('checkInDate', [$dateStart, $dateEnd])
            ->get();

        return view('report.list_report', compact('reportlist'))->with('data', $data)->with('dateStart', $dateStart)->with('dateEnd', $dateEnd)->with('exportData', false);
    }

    public function exportPDFGenerated($exportData, $dateStart, $dateEnd)
    {

        if ($exportData) {

            if ($exportData == 'GeneratedReport') {
                // Query for generated report
                $data = DB::table('visitrecord')
                    ->orderBy('visitrecord.id', 'desc')
                    ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                    ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                    ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                    ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                    ->whereBetween('checkInDate', [$dateStart, $dateEnd])
                    ->get();
            } else {
                // Handle other cases if needed
                // For example, if no button is clicked
                $data = null;
            }
        } else {
            $data = null;
        }

        // Generate HTML table markup
        $table = '<h3>Record List</h3>';
        $table .= '<table style="border-collapse: collapse; width: 100%;">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">ID</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Contractor/Visitor Name</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Staff Name</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">CheckIn</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">CheckOut</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Purpose</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Agenda</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';

        foreach ($data as $record) {
            $table .= '<tr>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->id . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->cont_visit_name . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->staff_name . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->checkInDate . ' ' . $record->checkInTime . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->checkOutDate . ' ' . $record->checkOutTime . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->appointmentPurpose . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->appointmentAgenda . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';

        // Generate PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($table);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = 'Report_' . time() . '.pdf';

        // Save the PDF to storage/app/public directory
        $dompdf->stream($filename);

        // Return the file download response
        return response()->download(public_path('storage/' . $filename))->deleteFileAfterSend(true);
    }

    public function exportPDFAll($exportData)
    {

        if ($exportData) {

            if ($exportData == 'AllReport') {
                // Query for all report
                $data = DB::table('visitrecord')
                    ->orderBy('visitrecord.id', 'desc')
                    ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                    ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                    ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                    ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                    ->get();
            } else {
                // Handle other cases if needed
                // For example, if no button is clicked
                $data = null;
            }
        } else {
            $data = null;
        }

        // Generate HTML table markup
        $table = '<h3>Record List</h3>';
        $table .= '<table style="border-collapse: collapse; width: 100%;">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">ID</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Contractor/Visitor Name</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Staff Name</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">CheckIn</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">CheckOut</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Purpose</th>';
        $table .= '<th style="border: 1px solid #000; padding: 8px;">Agenda</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';

        foreach ($data as $record) {
            $table .= '<tr>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->id . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->cont_visit_name . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->staff_name . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->checkInDate . ' ' . $record->checkInTime . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->checkOutDate . ' ' . $record->checkOutTime . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->appointmentPurpose . '</td>';
            $table .= '<td style="border: 1px solid #000; padding: 8px;">' . $record->appointmentAgenda . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';

        // Generate PDF using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($table);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = 'Report_' . time() . '.pdf';

        // Save the PDF to storage/app/public directory
        $dompdf->stream($filename);

        // Return the file download response
        return response()->download(public_path('storage/' . $filename))->deleteFileAfterSend(true);
    }

    public function exportExcelAll($exportData)
    {
        if ($exportData) {

            if ($exportData == 'AllReport') {
                // Query for all report
                $data = DB::table('visitrecord')
                    ->orderBy('visitrecord.id', 'desc')
                    ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                    ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                    ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                    ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                    ->get();
            } else {
                // Handle other cases if needed
                // For example, if no button is clicked
                $data = null;
            }
        } else {
            $data = null;
        }

        // Generate the CSV content
        $csv = "ID,Contractor/Visitor Name,Staff Name,CheckIn,CheckOut,Purpose,Agenda\r\n";

        foreach ($data as $record) {
            $csv .= $record->id . ','
                . $record->cont_visit_name . ','
                . $record->staff_name . ','
                . $record->checkInDate . ' ' . $record->checkInTime . ','
                . $record->checkOutDate . ' ' . $record->checkOutTime . ','
                . $record->appointmentPurpose . ','
                . $record->appointmentAgenda . "\r\n";
        }

        // Generate the Excel file
        $filename = 'visit_records.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        return Response::make($csv, 200, $headers);
    }

    public function exportExcelGenerated($exportData, $dateStart, $dateEnd)
    {
        if ($exportData) {

            if ($exportData == 'GeneratedReport') {
                // Query for generated report
                $data = DB::table('visitrecord')
                    ->orderBy('visitrecord.id', 'desc')
                    ->join('appointmentinfo', 'appointmentinfo.id', '=', 'visitrecord.appointmentID')
                    ->join('users as cont_visit_user', 'appointmentinfo.contVisitID', '=', 'cont_visit_user.id')
                    ->join('users as staff_user', 'appointmentinfo.staffID', '=', 'staff_user.id')
                    ->select('visitrecord.*', 'cont_visit_user.*', 'appointmentinfo.*', 'cont_visit_user.name as cont_visit_name', 'staff_user.name as staff_name')
                    ->whereBetween('checkInDate', [$dateStart, $dateEnd])
                    ->get();
            } else {
                // Handle other cases if needed
                // For example, if no button is clicked
                $data = null;
            }
        } else {
            $data = null;
        }

        // Generate the CSV content
        $csv = "ID,Contractor/Visitor Name,Staff Name,CheckIn,CheckOut,Purpose,Agenda\r\n";

        foreach ($data as $record) {
            $csv .= $record->id . ','
                . $record->cont_visit_name . ','
                . $record->staff_name . ','
                . $record->checkInDate . ' ' . $record->checkInTime . ','
                . $record->checkOutDate . ' ' . $record->checkOutTime . ','
                . $record->appointmentPurpose . ','
                . $record->appointmentAgenda . "\r\n";
        }

        // Generate the Excel file
        $filename = 'visit_records.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        return Response::make($csv, 200, $headers);
    }
}
