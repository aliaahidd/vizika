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
//store additional contractor info
Route::post('/contractor-info', [App\Http\Controllers\ProfileController::class, 'storecontractorinfo'])->name('storecontractorinfo');
Route::post('/info', [App\Http\Controllers\ProfileController::class, 'storevisitorinfo'])->name('storevisitorinfo');


//APPOINTMENT
//appointment page
Route::get('/appointment', [App\Http\Controllers\AppointmentController::class, 'appointment'])->name('appointment');
//display page
Route::get('/create-appointment', [App\Http\Controllers\AppointmentController::class, 'setappointment'])->name('appointment/setappointment');
//query insert appointment
Route::post('/set-appointment/{id}', [App\Http\Controllers\AppointmentController::class, 'storeappointment'])->name('storeappointment');

//choose visitor page load
Route::get('/appointment/choose-visitor', [App\Http\Controllers\AppointmentController::class, 'choosevisitorform'])->name('appointment/choosevisitor');
//create appointment page load
Route::get('/appointment/create-appointment/{id}', [App\Http\Controllers\AppointmentController::class, 'createappointmentform'])->name('appointment/createappointment');
//register visitor page load
Route::get('/appointment/register-visitor', [App\Http\Controllers\AppointmentController::class, 'registervisitorform'])->name('appointment/registervisitorform');
//register visitor (insert)
Route::post('/register-visitor', [App\Http\Controllers\AppointmentController::class, 'registervisitor'])->name('registervisitor');

//visitor list page
Route::get('/visitor', [App\Http\Controllers\ProfileController::class, 'visitor'])->name('visitor');