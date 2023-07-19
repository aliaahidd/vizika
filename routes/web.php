<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//do not want to display welcome page 
Route::get('/', function () {
    if ($user = Auth::user()) {
        //if login
        return redirect('/dashboard');
    } else {
        //if not login
        return redirect('login');
    }
});

Auth::routes();
Route::get('/login-user', function () {
    return view('auth.login_user');
})->name('loginuser');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //nama kat url link / nama function / nama panggil kat interface
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'loadDashboard'])->name('dashboard');
//dashboard for visitor
Route::get('/Dashboard/Visitor', [App\Http\Controllers\DashboardController::class, 'visitorDashboard'])->name('dashboardVisitor');
//dashboard for contractor
Route::get('/Dashboard-Contractor', [App\Http\Controllers\DashboardController::class, 'contractorDashboard'])->name('dashboardContractor');
//dashboard for officer
Route::get('/Dashboard/SHEQ-Officer', [App\Http\Controllers\DashboardController::class, 'officerDashboard'])->name('dashboardOfficer');
//dashboard for guard
Route::get('/Dashboard-SHEQ-Guard', [App\Http\Controllers\DashboardController::class, 'guardDashboard'])->name('dashboardGuard');
//dashboard for staff
Route::get('/Dashboard-Staff', [App\Http\Controllers\DashboardController::class, 'staffDashboard'])->name('dashboardStaff');


//PROFILE 
//display profile page (all user)
Route::get('/Profile/{id}', [App\Http\Controllers\ProfileController::class, 'loadProfile'])->name('profile');
//display edit profile page (all user)
Route::get('/Profile/Edit-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'editprofile'])->name('editprofile');
//choose visitor page load
Route::get('/User-List', [App\Http\Controllers\ProfileController::class, 'userlist'])->name('userlist');
//choose visitor page load
Route::get('/Registered-List', [App\Http\Controllers\ProfileController::class, 'registeredby'])->name('registeredby');
//view detail for approval from staff
Route::get('/Registered-User-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'registeredprofile'])->name('registeredprofile');
//approve user 
Route::get('approveuser/{id}', [App\Http\Controllers\ProfileController::class, 'approveuser'])->name('approveuser');
//register visitor page load
Route::get('/Register-User', [App\Http\Controllers\ProfileController::class, 'registeruserform'])->name('registeruserform');
//register visitor (insert)
Route::post('/register-visitor', [App\Http\Controllers\ProfileController::class, 'registervisitor'])->name('registervisitor');
//query edit profile page (contractor)
Route::put('updateprofilecontractor/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileContractor'])->name('updateProfileContractor');
//query edit profile page (visitor)
Route::put('updateprofilevisitor/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileVisitor'])->name('updateProfileVisitor');
//display page contractor detail
Route::get('/Contractor-Detail', [App\Http\Controllers\ProfileController::class, 'contractordetail'])->name('contractordetail');
//display page contractor detail
Route::get('/Visitor-Detail', [App\Http\Controllers\ProfileController::class, 'visitordetail'])->name('visitordetail');
//store additional contractor info
Route::post('/contractor-info', [App\Http\Controllers\ProfileController::class, 'storecontractorinfo'])->name('storecontractorinfo');
//store additional visitor info
Route::post('/visitor-info', [App\Http\Controllers\ProfileController::class, 'storevisitorinfo'])->name('storevisitorinfo');
//change password
Route::get('/change-password/{id}', [App\Http\Controllers\ProfileController::class, 'changepassword'])->name('change-password');
//update password
Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('update-password');
//staff list 
Route::get('/Staff-List', [App\Http\Controllers\ProfileController::class, 'stafflist'])->name('stafflist');
//staff list 
Route::delete('/deletestaff/{id}', [App\Http\Controllers\ProfileController::class, 'deletestaff'])->name('deletestaff');


//APPOINTMENT
//appointment page
Route::get('/Appointment', [App\Http\Controllers\AppointmentController::class, 'appointment'])->name('appointment');
//appointment details page
Route::get('/Appointment-Details/{id}', [App\Http\Controllers\AppointmentController::class, 'appointmentdetails'])->name('appointmentdetails');
//appointment page
Route::get('/Appointment-Today', [App\Http\Controllers\AppointmentController::class, 'appointmenttoday'])->name('appointment/today');
//query insert appointment multiple 
Route::post('/set-appointment-multiple', [App\Http\Controllers\AppointmentController::class, 'storeappointmentmultiple'])->name('storeappointmentmultiple');
//create appointment page load
Route::get('/Appointment/Create-appointment', [App\Http\Controllers\AppointmentController::class, 'createappointmentform'])->name('appointment/createappointment');
//route to the aattend the visit
Route::get('/Attend-visit/{id}', [App\Http\Controllers\AppointmentController::class, 'attendvisit'])->name('attendvisit');
//route to the not aattend the visit
Route::get('/Not-attend-visit/{id}', [App\Http\Controllers\AppointmentController::class, 'notattendvisit'])->name('notattendvisit');
//laptop info
Route::post('/Laptop-info/{id}', [App\Http\Controllers\AppointmentController::class, 'laptopinfo'])->name('laptopinfo');
//laptop info
Route::post('/Vehicle-info/{id}', [App\Http\Controllers\AppointmentController::class, 'vehicleinfo'])->name('vehicleinfo');
//route to approve laptop
Route::get('/Approve-Laptop/{id}', [App\Http\Controllers\AppointmentController::class, 'approveLaptop'])->name('approveLaptop');
//route to reject laptop
Route::get('/Reject-Laptop/{id}', [App\Http\Controllers\AppointmentController::class, 'rejectLaptop'])->name('rejectLaptop');
// //show modal visitor
// Route::get('/visitor/{id}', [App\Http\Controllers\AppointmentController::class, 'modalVisitor'])->name('visitor.showV');
// //show modal contractor
// Route::get('/contractor/{id}', [App\Http\Controllers\AppointmentController::class, 'modalContractor'])->name('contractor.showC');

//show modal visitor
Route::get('/visitor/{id}', [App\Http\Controllers\AppointmentController::class, 'todayAppointmentVisitor'])->name('visitor.showV');
//show modal contractor
Route::get('/contractor/{id}', [App\Http\Controllers\AppointmentController::class, 'todayAppointmentContractor'])->name('contractor.showC');

//RECORD VISIT
//past record lisr
Route::get('/Record', [App\Http\Controllers\RecordController::class, 'record'])->name('record');
//past appointment history page
Route::get('/Appointment-History', [App\Http\Controllers\RecordController::class, 'historyappointment'])->name('historyappointment');
//visitor log
Route::get('/Visitor-Log', [App\Http\Controllers\RecordController::class, 'visitorlog'])->name('logvisitor');
//visitor log scan qr
Route::get('/Visitor-Log-Scan', [App\Http\Controllers\RecordController::class, 'visitorlogqrcode'])->name('logvisitorqrcode');
//checkin user
Route::post('/checkin-user/{id}', [App\Http\Controllers\RecordController::class, 'checkinuser'])->name('checkinuser');
//checkout
Route::get('/checkout/{id}', [App\Http\Controllers\RecordController::class, 'checkout'])->name('checkout');
//checkout qr scan
Route::get('/checkout-QR/{id}', [App\Http\Controllers\RecordController::class, 'checkoutQR'])->name('checkoutQR');

//SAFTEY BRIEFING
//safety briefing list 
Route::get('/Briefing-List', [App\Http\Controllers\BriefingController::class, 'briefing'])->name('briefing');
// session list 
Route::get('/Biefing/Briefing-Session/{id}', [App\Http\Controllers\BriefingController::class, 'briefingsession'])->name('briefingsession');
//create briefing info 
Route::get('/Briefing/Create-Briefing-Info', [App\Http\Controllers\BriefingController::class, 'createbriefinginfo'])->name('briefing/createbriefinginfo');
// store briefing info
Route::post('/set-briefing', [App\Http\Controllers\BriefingController::class, 'storebriefinginfo'])->name('storebriefinginfo');
//enroll briefing session
Route::get('/briefingsession/{id}', [App\Http\Controllers\BriefingController::class, 'enrollbriefing'])->name('enrollbriefing');
//update validity pass date
Route::get('/Update-Validity-Pass/{id}', [App\Http\Controllers\BriefingController::class, 'updatepassdate'])->name('updatepassdate');
//delete the participant record
Route::get('/Delete-participant/{id}', [App\Http\Controllers\BriefingController::class, 'deleterecord'])->name('deleterecord');

//REPORT
//report list
Route::get('/Report', [App\Http\Controllers\ReportController::class, 'report'])->name('report');
//generatereport
Route::get('/Report-Generated', [App\Http\Controllers\ReportController::class, 'generatereport'])->name('generatereport');
//export pdf 
Route::get('/export-pdf-all/{exportData}', [App\Http\Controllers\ReportController::class, 'exportPDFAll'])->name('exportPDFAll');
//export pdf 
Route::get('/export-pdf-generated/{exportData}/{dateStart}/{dateEnd}', [App\Http\Controllers\ReportController::class, 'exportPDFGenerated'])->name('exportPDFGenerated');
//export excel 
Route::get('/export-excel-all/{exportData}', [App\Http\Controllers\ReportController::class, 'exportExcelAll'])->name('exportExcelAll');
//export excel 
Route::get('/export-excel-generated/{exportData}/{dateStart}/{dateEnd}', [App\Http\Controllers\ReportController::class, 'exportExcelGenerated'])->name('exportExcelGenerated');

//CALENDAR
//display calendar
Route::get('/Calendar', [App\Http\Controllers\CalendarController::class, 'calendar'])->name('calendar');
//display calendar
Route::get('/Calendar-Staff', [App\Http\Controllers\CalendarController::class, 'calendarstaff'])->name('calendarstaff');
// calendar ajax
Route::post('/calendarAjax', [App\Http\Controllers\CalendarController::class, 'calendarAjax'])->name('calendarAjax');

//BLACKLIST
//visitor list page
Route::get('/Active-User', [App\Http\Controllers\BlacklistController::class, 'activeUser'])->name('useractive');
//blacklist list page
Route::get('/list-blacklist', [App\Http\Controllers\BlacklistController::class, 'blacklistlist'])->name('userblacklist');
//blacklist
Route::post('/blacklist/{id}', [App\Http\Controllers\BlacklistController::class, 'blacklist'])->name('blacklist');
//blacklist
Route::get('/unblacklist/{id}', [App\Http\Controllers\BlacklistController::class, 'unblacklist'])->name('unblacklist');
//profile visitor
Route::get('/Profile-Visitor/{id}', [App\Http\Controllers\BlacklistController::class, 'profilevisitor'])->name('profile-visitor');
//profile contractor
Route::get('/Profile-Contractor/{id}', [App\Http\Controllers\BlacklistController::class, 'profilecontractor'])->name('profile-contractor');

//COMPANY
//company list
Route::get('/Company', [App\Http\Controllers\CompanyController::class, 'company'])->name('company');
//query insert appointment multiple 
Route::post('/storecompanyinfo', [App\Http\Controllers\CompanyController::class, 'storecompanyinfo'])->name('storecompanyinfo');
//create appointment page load
Route::get('/Company/Create-company', [App\Http\Controllers\CompanyController::class, 'createcompany'])->name('createcompany');
//edit company
Route::get('/Company/Edit-company/{id}', [App\Http\Controllers\CompanyController::class, 'editcompany'])->name('edit-company');
//update company
Route::post('/update-company/{id}', [App\Http\Controllers\CompanyController::class, 'updatecompany'])->name('updatecompany');


//BIOMETRIC
//biometric facial recog
Route::get('/Facial-Recognition', [App\Http\Controllers\BiometricController::class, 'facialRecog'])->name('facialRecog');
//register biometric page
Route::get('/Register-Biometric', [App\Http\Controllers\BiometricController::class, 'registerBiometric'])->name('registerBiometric');
//save picture taken
Route::post('/save-image', [App\Http\Controllers\BiometricController::class, 'saveImage'])->name('saveImage');
//scan biometric page
Route::get('/Scan-Biometric/{id}', [App\Http\Controllers\BiometricController::class, 'scanBiometric'])->name('scanBiometric');
//get data from scan image
Route::get('/getPhoto/{userID}', [App\Http\Controllers\BiometricController::class, 'getUserInformation']);

//QR CODE FOR VISITOR WITHOUT INVITATION
//qr code for visitor that come without appointment
Route::get('/Qr-Code', [App\Http\Controllers\QRCodeController::class, 'qrcode'])->name('qrcode');
//QR Code
Route::get('/qrcode', [App\Http\Controllers\QRCodeController::class, 'generateQrCode'])->name('generateQrCode');
//visitor form that come without invitation
Route::get('/Visitor-Form', [App\Http\Controllers\QRCodeController::class, 'visitorform'])->name('visitorform');
//store additional visitor info
Route::post('/visitor-form', [App\Http\Controllers\QRCodeController::class, 'storevisitorform'])->name('storevisitorform');

//FINISH FORM
//get data from scan image
Route::get('/finish-form', function () {
    $recommend = DB::table('users')
        ->join('users as recommended', 'users.recommendedby', '=', 'recommended.id')
        ->where('users.id', Auth::user()->id)
        ->first();

    return view('layouts.finishform',  compact('recommend'));
})->name('finishform');

Route::get('/complete-form-visit', function () {
    return view('record.form_complete');
})->name('completeformvisit');