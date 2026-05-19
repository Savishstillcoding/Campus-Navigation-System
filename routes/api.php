<?php

use App\Http\Controllers\QRController;
use Illuminate\Support\Facades\Route;

Route::prefix('qr')->group(function () {
    Route::post('/scan', [QRController::class, 'scan'])->name('qr.scan');
    Route::get('/rooms', [QRController::class, 'getAllRooms'])->name('qr.rooms');
    Route::get('/rooms/floor/{floor}', [QRController::class, 'getRoomsByFloor'])->name('qr.rooms.floor');
});
