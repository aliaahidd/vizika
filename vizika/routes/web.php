<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//PROFILE 
//display profile page (all user)
Route::get('/Profile/{id}', [App\Http\Controllers\ProfileController::class, 'loadProfile'])->name('profile');
//display edit profile page (all user)
Route::get('/Profile/Edit-Profile/{id}', [App\Http\Controllers\ProfileController::class, 'editprofile'])->name('editprofile');
//query edit profile page (all user)
Route::put('updateprofile/{id}', [App\Http\Controllers\ProfileController::class, 'updateprofile'])->name('updateprofile');
//display page contractor detail
Route::get('/contractor-detail', [App\Http\Controllers\ProfileController::class, 'contractordetail'])->name('contractordetail');
//display page contractor detail
Route::get('/visitor-detail', [App\Http\Controllers\ProfileController::class, 'visitordetail'])->name('visitordetail');
//store additional contractor info
Route::post('/contractor-info', [App\Http\Controllers\ProfileController::class, 'storecontractorinfo'])->name('storecontractorinfo');
//store additional visitor info
Route::post('/visitor-info', [App\Http\Controllers\ProfileController::class, 'storevisitorinfo'])->name('storevisitorinfo');
//visitor list page
Route::get('/visitor', [App\Http\Controllers\ProfileController::class, 'visitor'])->name('visitor');


//APPOINTMENT
//appointment page
Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'appointment'])->name('appointment');
//query insert appointment
Route::post('/set-appointment', [App\Http\Controllers\AppointmentController::class, 'storeappointment'])->name('storeappointment');
//choose visitor page load
Route::get('/appointment/choose-visitor', [App\Http\Controllers\AppointmentController::class, 'choosevisitorform'])->name('choosevisitor');
//create appointment page load
Route::get('/appointment/create-appointment', [App\Http\Controllers\AppointmentController::class, 'createappointmentform'])->name('appointment/createappointment');
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
//visitor log
Route::get('/Visitor-Log', [App\Http\Controllers\RecordController::class, 'visitorlog'])->name('logvisitor');
//show modal visitor
Route::get('/checkin-visitor/{id}', [App\Http\Controllers\RecordController::class, 'checkinvisitor'])->name('checkin-visitor');
//show modal visitor
Route::get('/checkin-contractor/{id}', [App\Http\Controllers\RecordController::class, 'checkincontractor'])->name('checkin-contractor');
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

//CALENDAR
//calendar
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'calendar'])->name('calendar');

