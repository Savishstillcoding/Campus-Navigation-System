<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('websitepage');
})->name('home');

Route::get('/signin', function () {
    return view('signIN');
})->name('signin');

Route::get('/signup', function () {
    return view('studentsignup');
})->name('signup');

Route::get('/student-home', function () {
    return view('main');
})->name('student-home');

Route::get('/visitor-home', function () {
    return view('main');
})->name('visitor-home');

Route::get('/main', function () {
    return view('main'); // or dashboard.blade.php
})->name('portal');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
