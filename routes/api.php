<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ComputerController;
use \App\Http\Controllers\StaffApiController;

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
    Route::post('/admin/login', 'login')->name('attendance.login');
    
    
    //Authenticated Admin Only
    Route::group(['middleware'=> ['auth:sanctum']], function(){
        Route::get('/staff/list', 'staff_list');
        Route::get('/staff/logs', 'staff_logs');
        Route::post('/staff/edit/{id}', 'update');
        Route::post('/staff/delete/{id}', 'delete');
        Route::post('/entry', 'entry');
        Route::get('/linechart', 'linechart');
    });

});

