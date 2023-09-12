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
Route::get('/register-contractor', function () {
    Auth::logout();
    $companylist = DB::table('companyinfo')
        ->orderBy('companyName', 'asc')
        ->get();
    return view('auth.register_contractor', compact('companylist'));
})->name('loginuser');

Route::get('/register-company', function () {
    Auth::logout();
    return view('auth.register_company');
})->name('logincompany');

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
//dashboard for contractor
Route::get('/Dashboard-Company', [App\Http\Controllers\DashboardController::class, 'companyDashboard'])->name('dashboardCompany');


//PROFILE 
//display profile page (all user)
Route::get('/Profile/{id}', [App\Http\Controllers\ProfileController::class, 'loadProfile'])->name('profile');
//display edit profile page (all user)
Route::get('/Profile/Edit-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'editprofile'])->name('editprofile');
//choose visitor page load
Route::get('/User-List', [App\Http\Controllers\ProfileController::class, 'userlist'])->name('userlist');
//registration approval by officer
Route::get('/Registered-List', [App\Http\Controllers\ProfileController::class, 'registeredby'])->name('registeredby');
//view detail for approval from staff
Route::get('/Registered-User-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'registeredprofile'])->name('registeredprofile');
//approve user 
Route::get('approveuser/{id}', [App\Http\Controllers\ProfileController::class, 'approveuser'])->name('approveuser');
//reject user 
Route::post('rejectuser/{id}', [App\Http\Controllers\ProfileController::class, 'rejectuser'])->name('rejectuser');
//approve user all 
Route::get('approveallregistration', [App\Http\Controllers\ProfileController::class, 'approveallregistration'])->name('approveallregistration');
//register visitor page load
Route::get('/Register-User', [App\Http\Controllers\ProfileController::class, 'registeruserform'])->name('registeruserform');
//bulk registration form
Route::get('/Bulk-Registration', [App\Http\Controllers\ProfileController::class, 'bulkregistration'])->name('bulkregistration');
//downlaod guideline excel
Route::get('/Excel-Download/{fileType}', [App\Http\Controllers\ProfileController::class, 'exceldownload'])->name('exceldownload');
//send invitation using email
Route::post('/send-invitation', [App\Http\Controllers\ProfileController::class, 'sendinvitationemail'])->name('sendinvitationemail');
//register visitor (insert)
Route::post('/register-visitor', [App\Http\Controllers\ProfileController::class, 'registervisitor'])->name('registervisitor');
//register contractor (insert)
Route::post('/register-contractor', [App\Http\Controllers\ProfileController::class, 'registercontractor'])->name('registercontractor');
//register company (insert)
Route::post('/register-company', [App\Http\Controllers\ProfileController::class, 'registercompany'])->name('registercompany');
//register bulk using excel store
Route::post('/bulk-excel-file', [App\Http\Controllers\ProfileController::class, 'registerbulkfile'])->name('registerbulkfile');
//query edit profile page (contractor)
Route::put('updateprofilecontractor/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileContractor'])->name('updateProfileContractor');
//query edit profile page (contractor)
Route::put('updateBriefingInfo/{id}', [App\Http\Controllers\ProfileController::class, 'updateBriefingInfo'])->name('updateBriefingInfo');
//query edit profile page (visitor)
Route::put('updateprofilevisitor/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileVisitor'])->name('updateProfileVisitor');
//display page contractor detail
Route::get('/Contractor-Detail', [App\Http\Controllers\ProfileController::class, 'contractordetail'])->name('contractordetail');
//display page contractor detail
Route::get('/Visitor-Detail', [App\Http\Controllers\ProfileController::class, 'visitordetail'])->name('visitordetail');
//store additional contractor info
Route::post('/contractor-info', [App\Http\Controllers\ProfileController::class, 'storecontractorinfo'])->name('storecontractorinfo');
//store additional contractor info
Route::post('/safety-briefing-contractor-info', [App\Http\Controllers\ProfileController::class, 'updatesafetybriefing'])->name('updatesafetybriefing');
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

//APPOINTMENT
//contract page
Route::get('/Contract', [App\Http\Controllers\ContractController::class, 'contract'])->name('contract');
//contractor transport details
Route::get('/Contract-Details/{id}', [App\Http\Controllers\ContractController::class, 'contractdetails'])->name('contractdetails');
//regsiter transport
Route::get('/Contract/Register-Contract', [App\Http\Controllers\ContractController::class, 'registerContract'])->name('contract/createcontract');
//store transport registration with contractor 
Route::post('/Store-Contract', [App\Http\Controllers\ContractController::class, 'storecontract'])->name('storecontract');

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
//safety briefing slot default and create new one 
Route::get('/Briefing-Slot', [App\Http\Controllers\BriefingController::class, 'briefingSlot'])->name('briefingSlot');
// session list 
Route::get('/Biefing/Briefing-Session/{id}', [App\Http\Controllers\BriefingController::class, 'briefingsession'])->name('briefingsession');
//create briefing info 
Route::get('/Briefing/Create-Briefing-Info', [App\Http\Controllers\BriefingController::class, 'createbriefinginfo'])->name('briefing/createbriefinginfo');
// store briefing info
Route::post('/set-briefing', [App\Http\Controllers\BriefingController::class, 'storebriefinginfo'])->name('storebriefinginfo');
//enroll briefing session
Route::get('/briefingsession/{id}', [App\Http\Controllers\BriefingController::class, 'enrollbriefing'])->name('enrollbriefing');
//enroll briefing first timer
Route::get('/enroll-briefing-first-timer/{id}', [App\Http\Controllers\BriefingController::class, 'enrollbriefingfirsttimer'])->name('enrollbriefingfirsttimer');
//cancel briefing session
Route::get('/cancelsession/{id}', [App\Http\Controllers\BriefingController::class, 'cancelsession'])->name('cancelsession');
//edit briefing session
Route::get('/editbriefing/{id}', [App\Http\Controllers\BriefingController::class, 'editbriefing'])->name('editbriefing');
//update briefing session
Route::post('/updatebriefinginfodata/{id}', [App\Http\Controllers\BriefingController::class, 'updatebriefinginfodata'])->name('updatebriefinginfodata');
//update validity pass date
Route::get('/Update-Validity-Pass/{id}', [App\Http\Controllers\BriefingController::class, 'updatepassdate'])->name('updatepassdate');
//delete the participant record
Route::get('/Delete-participant/{id}', [App\Http\Controllers\BriefingController::class, 'deleterecord'])->name('deleterecord');
//expiry pass list 
Route::get('/Expiry-Pass-List', [App\Http\Controllers\BriefingController::class, 'expirypasslist'])->name('expirypasslist');
//book briefing
Route::get('/Book-Briefing', [App\Http\Controllers\BriefingController::class, 'bookbriefing'])->name('bookbriefing');


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
//display page company detail
Route::get('/Company-Detail', [App\Http\Controllers\CompanyController::class, 'companydetail'])->name('companydetail');
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

//TRANSPORT 
//transport list 
Route::get('/Contractor-Transport', [App\Http\Controllers\TransportController::class, 'contractortransport'])->name('contractortransport');
//contractor transport details
Route::get('/Contractor-Transport-Details/{id}', [App\Http\Controllers\TransportController::class, 'contractortransportdetails'])->name('contractortransportdetails');
//regsiter transport
Route::get('/Contractor-Transport/Register-Transport', [App\Http\Controllers\TransportController::class, 'registerTransport'])->name('contractortransport/registerTransport');
//checkout trasnport 
Route::get('/checkout-transport/{id}', [App\Http\Controllers\TransportController::class, 'checkoutTransport'])->name('checkoutTransport');
//store transport registration with contractor 
Route::post('/Store-Transport-Registration', [App\Http\Controllers\TransportController::class, 'storetransportregistration'])->name('storetransportregistration');
//transport inspection list 
Route::get('/Transport-Inspection', [App\Http\Controllers\TransportController::class, 'transportInspection'])->name('transportInspection');
//transport inspection form 
Route::get('/Transport-Inspection/InspectionForm', [App\Http\Controllers\TransportController::class, 'inspectionform'])->name('transportInspection/inspectionform');
//store inspection
Route::post('/Store-Inspection', [App\Http\Controllers\TransportController::class, 'storeinspection'])->name('storeinspection');
//vehicle list 
Route::get('/Vehicle', [App\Http\Controllers\TransportController::class, 'transportvehicle'])->name('transportvehicle');
//regsiter transport
Route::get('/Vehicle/Register-Vehicle', [App\Http\Controllers\TransportController::class, 'registerVehicle'])->name('transport/registerVehicle');
//store transport registration with contractor 
Route::post('/Store-Vehicle-Registration', [App\Http\Controllers\TransportController::class, 'storevehicleregistration'])->name('storevehicleregistration');




//FINISH FORM
//get data from scan image
Route::get('/finish-form', function () {
    return view('layouts.finishform');
})->name('finishform');

Route::get('/complete-form-visit', function () {
    return view('record.form_complete');
})->name('completeformvisit');
