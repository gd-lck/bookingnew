<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::post('/midtrans/webhook', [BookingController::class, 'webhook']);
