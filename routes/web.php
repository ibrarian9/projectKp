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


Route::get('/', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login-proses', [LoginController::class, 'loginDashboard'])->name('login-proses');

Route::middleware(['auth','preventBack',])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');
    Route::get('/peserta/{id}', [PenggunaController::class, 'tampilPeserta'])->name('tampil');
    Route::get('/penilaian/{id}', [PenggunaController::class, 'tampilPenilaian'])->name('penilaian');
    Route::get('/penilaian/{id}/{timId}/{juriId}', [PenggunaController::class, 'inputNilai'])->name('inputNilai');
    Route::post('/penilaian', [PenggunaController::class, 'postNilai'])->name('postNilai');
    Route::get('/kategoriNomorLomba', [PenggunaController::class, 'kategoriNomorPerlombaan'])->name('kategoriNomorLomba');
    Route::get('/kategoriNomorLomba/{id}', [PenggunaController::class, 'detailKategoriNomorPerlombaan'])->name('detailKategoriNomorLomba');
    Route::get('/pengguna/users', [PenggunaController::class, 'semuaUsers'])->name('dataUsers');
    Route::get('/pengguna/tambah', [PenggunaController::class,'tambah'])->name('dataUsers.tambah');
    Route::post('/pengguna/tambah', [PenggunaController::class,'simpan'])->name('dataUsers.simpan');
    Route::get('/pengguna/edit/{id}', [PenggunaController::class,'edit'])->name('dataUsers.edit');
    Route::post('/pengguna/edit/{id}', [PenggunaController::class,'update'])->name('dataUsers.update');
    Route::get('/pengguna/hapus/{id}', [PenggunaController::class,'hapus'])->name('dataUsers.hapus');
});


