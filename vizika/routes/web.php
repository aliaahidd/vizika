<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //nama kat url link / nama function / nama panggil kat interface
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'loadDashboard'])->name('dashboard');
//dashboard for visitor
Route::get('/dashboard/Visitor', [App\Http\Controllers\DashboardController::class, 'visitorDashboard'])->name('dashboardVisitor');
//dashboard for contractor
Route::get('/Dashboard-Contractor', [App\Http\Controllers\DashboardController::class, 'contractorDashboard'])->name('dashboardContractor');
//dashboard for officer
Route::get('/dashboard/SHEQ-Officer', [App\Http\Controllers\DashboardController::class, 'officerDashboard'])->name('dashboardOfficer');
//dashboard for guard
Route::get('/Dashboard-SHEQ-Guard', [App\Http\Controllers\DashboardController::class, 'guardDashboard'])->name('dashboardGuard');
//dashboard for staff
Route::get('/Dashboard-Staff', [App\Http\Controllers\DashboardController::class, 'staffDashboard'])->name('dashboardStaff');


//PROFILE 
//display profile page (all user)
Route::get('/Profile/{id}', [App\Http\Controllers\ProfileController::class, 'loadProfile'])->name('profile');
//display edit profile page (all user)
Route::get('/Profile/Edit-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'editprofile'])->name('editprofile');
//query edit profile page (contractor)
Route::put('updateprofile/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileContractor'])->name('updateProfileContractor');
//query edit profile page (visitor)
Route::put('updateprofile/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfileVisitor'])->name('updateProfileVisitor');
//display page contractor detail
Route::get('/contractor-detail', [App\Http\Controllers\ProfileController::class, 'contractordetail'])->name('contractordetail');
//display page contractor detail
Route::get('/visitor-detail', [App\Http\Controllers\ProfileController::class, 'visitordetail'])->name('visitordetail');
//store additional contractor info
Route::post('/contractor-info', [App\Http\Controllers\ProfileController::class, 'storecontractorinfo'])->name('storecontractorinfo');
//store additional visitor info
Route::post('/visitor-info', [App\Http\Controllers\ProfileController::class, 'storevisitorinfo'])->name('storevisitorinfo');


//APPOINTMENT
//appointment page
Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'appointment'])->name('appointment');
//appointment page
Route::get('/appointment-today', [App\Http\Controllers\AppointmentController::class, 'appointmenttoday'])->name('appointment/today');
//query insert appointment
Route::post('/set-appointment', [App\Http\Controllers\AppointmentController::class, 'storeappointment'])->name('storeappointment');
//query insert appointment multiple 
Route::post('/set-appointment-multiple', [App\Http\Controllers\AppointmentController::class, 'storeappointmentmultiple'])->name('storeappointmentmultiple');

//choose visitor page load
Route::get('/appointment/choose-visitor', [App\Http\Controllers\AppointmentController::class, 'choosevisitorform'])->name('choosevisitor');
//create appointment page load
Route::get('/appointment/create-appointment', [App\Http\Controllers\AppointmentController::class, 'createappointmentform'])->name('appointment/createappointment');
//create appointment page load
Route::get('/appointment/create-appointment-old', [App\Http\Controllers\AppointmentController::class, 'createappointmentformold'])->name('appointment/createappointmentformold');
//register visitor page load
Route::get('/appointment/register-visitor', [App\Http\Controllers\AppointmentController::class, 'registervisitorform'])->name('appointment/registervisitorform');
//register visitor (insert)
Route::post('/register-visitor', [App\Http\Controllers\AppointmentController::class, 'registervisitor'])->name('registervisitor');
//route to the aattend the visit
Route::get('/Attend-visit/{id}', [App\Http\Controllers\AppointmentController::class, 'attendvisit'])->name('attendvisit');
//route to the not aattend the visit
Route::get('/Not-attend-visit/{id}', [App\Http\Controllers\AppointmentController::class, 'notattendvisit'])->name('notattendvisit');
//show modal visitor
Route::get('/visitor/{id}', [App\Http\Controllers\AppointmentController::class, 'modalVisitor'])->name('visitor.showV');
//show modal contractor
Route::get('/contractor/{id}', [App\Http\Controllers\AppointmentController::class, 'modalContractor'])->name('contractor.showC');

//RECORD VISIT
//past record lisr
Route::get('/record', [App\Http\Controllers\RecordController::class, 'record'])->name('record');
//past appointment history page
Route::get('/Appointment-History', [App\Http\Controllers\RecordController::class, 'historyappointment'])->name('historyappointment');
//visitor log
Route::get('/Visitor-Log', [App\Http\Controllers\RecordController::class, 'visitorlog'])->name('logvisitor');
//show modal visitor
Route::post('/checkin-visitor/{id}', [App\Http\Controllers\RecordController::class, 'checkinvisitor'])->name('checkin-visitor');
//show modal visitor
Route::post('/checkin-contractor/{id}', [App\Http\Controllers\RecordController::class, 'checkincontractor'])->name('checkin-contractor');
//checkout
Route::get('/checkout/{id}', [App\Http\Controllers\RecordController::class, 'checkout'])->name('checkout');

//SAFTEY BRIEFING
//safety briefing list 
Route::get('/briefing', [App\Http\Controllers\BriefingController::class, 'briefing'])->name('briefing');
//create briefing info 
Route::get('/briefing/create-briefing-info', [App\Http\Controllers\BriefingController::class, 'createbriefinginfo'])->name('briefing/createbriefinginfo');
// store briefing info
Route::post('/set-briefing', [App\Http\Controllers\BriefingController::class, 'storebriefinginfo'])->name('storebriefinginfo');
//enroll briefing session
Route::get('/briefingsession/{id}', [App\Http\Controllers\BriefingController::class, 'enrollbriefing'])->name('enrollbriefing');

//REPORT
//report list
Route::get('/report', [App\Http\Controllers\ReportController::class, 'report'])->name('report');
//generatereport
Route::get('/Report-Generated', [App\Http\Controllers\ReportController::class, 'generatereport'])->name('generatereport');
//export pdf 
Route::get('/export-pdf-all/{exportData}', [App\Http\Controllers\ReportController::class, 'exportPDFAll'])->name('exportPDFAll');
//export pdf 
Route::get('/export-pdf-generated/{exportData}/{dateStart}/{dateEnd}', [App\Http\Controllers\ReportController::class, 'exportPDFGenerated'])->name('exportPDFGenerated');

//CALENDAR
//calendar
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'calendar'])->name('calendar');
Route::post('/calendarAjax', [App\Http\Controllers\CalendarController::class, 'calendarAjax'])->name('calendarAjax');

//BLACKLIST
//visitor list page
Route::get('/visitor', [App\Http\Controllers\BlacklistController::class, 'visitor'])->name('visitor');
//blacklist list page
Route::get('/list-blacklist', [App\Http\Controllers\BlacklistController::class, 'blacklistlist'])->name('blacklistlist');
//blacklist
Route::post('/blacklist/{id}', [App\Http\Controllers\BlacklistController::class, 'blacklist'])->name('blacklist');
//blacklist
Route::get('/unblacklist/{id}', [App\Http\Controllers\BlacklistController::class, 'unblacklist'])->name('unblacklist');
//profile visitor
Route::get('/Profile-Visitor/{id}', [App\Http\Controllers\BlacklistController::class, 'profilevisitor'])->name('profile-visitor');

