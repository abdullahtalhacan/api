<?php

use App\Http\Controllers\Admin\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Users\UserController;

require __DIR__.'/auth.php';

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'show'])
        ->name('user.show');
});

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::patch('/user', [UserController::class, 'update'])
        ->name('user.update');

    Route::patch('/user/change-password', [UserController::class, 'changePassword'])
        ->name('user.change-password');
});

Route::middleware('auth:api')->group(function () { // add verified later
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('settings', SettingController::class);
        Route::resource('appointments', AppointmentController::class);
    });
});

Route::group(['prefix' => 'site'], function () {
    Route::get('appointmentList', [SiteController::class, 'appointmentList']);
    Route::get('getSettings', [SiteController::class, 'getSettings']);
    Route::get('manageAppointment', [SiteController::class, 'manageAppointment']);
    Route::post('storeAppointment', [SiteController::class, 'storeAppointment']);
    Route::post('cancelAppointment', [SiteController::class, 'cancelAppointment']);
});
