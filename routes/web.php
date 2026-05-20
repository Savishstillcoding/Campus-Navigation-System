<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QRController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('websitepage');
})->name('home');

Route::get('/signin', function () {
    return view('signIN');
})->name('signin');

Route::post('/signin', [AuthController::class, 'signin'])->name('signin.store');

Route::get('/visitor-signin', function () {
    return view('signIN');
})->name('visitor-signin');

Route::post('/visitor-signin', [AuthController::class, 'visitorSignin'])->name('visitor.signin');

Route::get('/signup', function () {
    return view('studentsignup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'signup'])->name('signup.store');

Route::get('/student-home', function () {
    return view('main');
})->name('student-home');

Route::get('/qr-scanner', function () {
    return view('qr-scanner');
})->name('qr-scanner');

Route::get('/room/{id}', [QRController::class, 'show'])->name('room.details');

Route::get('/visitor-home', function () {
    return view('main');
})->name('visitor-home');

Route::get('/main', function () {
    return view('main'); // or dashboard.blade.php
})->name('portal');

// QR/API Routes
Route::prefix('api/qr')->group(function () {
    Route::post('/scan', [QRController::class, 'scan'])->name('qr.scan');
    Route::get('/rooms', [QRController::class, 'getAllRooms'])->name('qr.rooms');
    Route::get('/rooms/floor/{floor}', [QRController::class, 'getRoomsByFloor'])->name('qr.rooms.floor');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
