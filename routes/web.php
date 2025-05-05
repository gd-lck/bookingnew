<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilPerusahaanController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


Route::middleware(['auth','verified','role:admin'])->group(function(){
    Route::get('layanan/indeks', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{id}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    Route::get('karyawan/indeks', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::put('/booking/{id}/update-status', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');

    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/index', [UserController::class, 'index'])->name('users.index');

    Route::get('/perusahaan', [ProfilPerusahaanController::class, 'edit'])->name('perusahaan.edit');
    Route::post('/perusahaan', [ProfilPerusahaanController::class, 'update'])->name('perusahaan.update');

    Route::get('/laporan-booking', [BookingController::class, 'laporan'])->name('booking.laporan');
    Route::get('/laporan-booking/pdf', [BookingController::class, 'exportPdf'])->name('booking.export.pdf');

    Route::get('/admin/dashboard', [BookingController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth','verified','role:customer'])->group(function(){
    Route::get('customer/layanan',[LayananController::class, 'displayLayanan'])->name('customer.layanan.display');

    Route::post('/booking/create', [BookingController::class, 'create'])->name('customer.booking');
    Route::get('/booking/saya', [BookingController::class, 'userBooking'])->name('customer.userBooking');
    Route::put('/booking/reschedule/{id}', [BookingController::class, 'reschedule'])->name('booking.reschedule');
    Route::get('/booking/create/{layanan_id?}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/cek-karyawan', [BookingController::class, 'cariKaryawan'])->name('cek.karyawan');
    Route::get('/booking/pay/{booking}', [BookingController::class, 'payBooking'])->name('customer.payBooking');
    Route::get('/payment-success/{booking}', [BookingController::class, 'paymentSuccess'])->name('payment.success');

});

Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');



require __DIR__.'/auth.php';
