<?php

use App\Http\Controllers\HomeController;
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
    Route::post('/prescription-upload', [UploadController::class, 'upload'])->name('prescription.upload');

});

// Routes accessible only to authenticated pharmacy users
Route::middleware(['auth', 'pharmacy'])->group(function () {

});
