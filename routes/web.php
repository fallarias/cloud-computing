<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ComputerController;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\StaffApiController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('attendance.login');
// });

Route::get('computer', [ComputerController::class, 'index']);
Route::get('computer/{id}', [ComputerController::class, 'show']);
Route::post('computer', [ComputerController::class, 'store']);
Route::put('computer/{id}', [ComputerController::class, 'update']);
Route::delete('computer/{id}', [ComputerController::class, 'destroy']);
Route::post('computer/search', [ComputerController::class, 'search']);

Route::get('/user', function (Request $request) {
    //Route::get('/users', [AuthController::class, 'index']);
    return $request->user();
})->middleware('auth:sanctum');

Route::get('computer', [ComputerController::class, 'index']);
Route::get('computer/{id}', [ComputerController::class, 'show']);
Route::post('computer', [ComputerController::class, 'store']);
Route::put('computer/{id}', [ComputerController::class, 'update']);
Route::delete('computer/{id}', [ComputerController::class, 'destroy']);
Route::post('computer/search', [ComputerController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/users/{id}', [AuthController::class, 'index']);
});

Route::controller(StaffApiController::class)->group(function () {

    Route::post('/time-in', 'attendance_in');
    Route::post('/time-out', 'attendance_out');
    Route::post('/admin/login', 'login')->name('attendance.logins');
    Route::get('/admin/login', 'get_login')->name('attendance.login')->middleware('guest');
    Route::get('/', 'get_login')->name('attendance.login')->middleware('guest');
    Route::get('/attendance', 'attendance')->name('attendance.staffAttendance');
    
    //Authenticated Admin Only
    Route::group(['middleware'=> ['auth:sanctum']], function(){

        Route::group(['middleware' => function ($request, $next) {
        if (Auth::check() && Auth::user()->account_type !== 'Admin') {
            return redirect()->route('client.clientHomePage');
        }
        return $next($request);
    }], function() {

            Route::get('/staff/list', 'staff_list')->name("attendance.staffList");
            Route::get('/staff/logs', 'staff_logs')->name("attendance.staffLogs");
            Route::get('/entry', 'registration')->name("attendance.staffRegistration");
            Route::get('/dashboard', 'dashboard')->name("attendance.dashboard");

            Route::post('/staff/edit/{id}', 'update')->name("attendance.staffListEdit");
            Route::post('/staff/delete/{id}', 'delete')->name("attendance.staffLists");
            Route::post('/entry', 'entry')->name("attendance.staffRegistration");
            Route::get('/logout', 'logout')->name('attendance.logout');
        });

    });
});

