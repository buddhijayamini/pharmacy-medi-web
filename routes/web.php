<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/upload', [UploadController::class, 'index'])->name('upload');
    Route::post('/prescription/upload', [UploadController::class, 'upload'])->name('prescription.upload');
    Route::get('/prescription',  [UploadController::class, 'view'])->name('prescription');
    Route::get('/prescription/data',  [UploadController::class, 'data'])->name('prescription.data');
    Route::get('/prescription/admin',  [PharmacyController::class, 'adminView'])->name('prescription.admin');
    Route::get('/prescription/data/admin',  [PharmacyController::class, 'adminData'])->name('prescription.data.admin');
});

// // Routes accessible only to authenticated pharmacy users
// Route::middleware(['pharmacy'])->group(function () {
//     Route::get('/prescription/admin',  [PharmacyController::class, 'adminView'])->name('prescription.admin');
//     Route::get('/prescription/data/admin',  [PharmacyController::class, 'adminData'])->name('prescription.data.admin');
// });
