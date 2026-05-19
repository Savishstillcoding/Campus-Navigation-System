<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('websitepage');
})->name('home');

Route::get('/signin', function () {
    return view('signIN');
})->name('signin');

Route::post('/signin', [AuthController::class, 'signin'])->name('signin.store');

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

Route::get('/visitor-home', function () {
    return view('main');
})->name('visitor-home');

Route::get('/main', function () {
    return view('main'); // or dashboard.blade.php
})->name('portal');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
