<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/login-proses', [LoginController::class, 'loginDashboard'])->name('login-proses');
});

Route::middleware(['auth','preventBack'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');
    Route::get('/peserta/{id}', [PenggunaController::class, 'tampilPeserta'])->name('tampil');
    Route::get('/penilaian/{id}', [PenggunaController::class, 'tampilPenilaian'])->name('penilaian');

    Route::controller(PenggunaController::class)->prefix('pengguna')->group(function () {
        Route::get('/users', 'semuaUsers')->name('dataUsers');
        Route::get('tambah', 'tambah')->name('dataUsers.tambah');
        Route::post('tambah', 'simpan')->name('dataUsers.simpan');
        Route::get('edit/{id}', 'edit')->name('dataUsers.edit');
        Route::post('edit/{id}', 'update')->name('Pengguna.tambah.update');
        Route::get('hapus/{id}', 'hapus')->name('dataUsers.hapus');
    });
});


