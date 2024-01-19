<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenilaianController;
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
Route::get('/', function (){
   return view('Login');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/login-proses', [LoginController::class, 'loginDashboard'])->name('login-proses');
});

Route::middleware(['auth','preventBack'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PenggunaController::class, 'index'])->name('dashboard');
    Route::get('/dataPeserta', [PenggunaController::class, 'tampilPeserta'])->name('dashboard');

    // test
    Route::controller(PenilaianController::class)->prefix('Penilaian')->group(function () {
        Route::get('/PenilaianCerpen', 'tampilPenilaianCerpen')->name('PenilaianCerpen');
        Route::get('/PenilaianDakwah', 'tampilPenilaianDakwah')->name('PenilaianDakwah');
        Route::get('/PenilaianEsai', 'tampilPenilaianEsai')->name('PenilaianEsai');
        Route::get('/PenilaianFotografi', 'tampilPenilaianFotografi')->name('PenilaianFotografi');
        Route::get('/PenilaianHCMotion', 'tampilPenilaianHCMotion')->name('PenilaianHCMotion');
        Route::get('/PenilaianLaguReligi', 'tampilPenilaianLaguReligi')->name('PenilaianLaguReligi');
        Route::get('/PenilaianPaper', 'tampilPenilaianPaper')->name('PenilaianPaper');
        Route::get('/PenilaianPoster', 'tampilPenilaianPoster')->name('PenilaianPoster');
        Route::get('/PenilaianProposal', 'tampilPenilaianProposal')->name('PenilaianProposal');
        Route::get('/PenilaianQiraah', 'tampilPenilaianQiraah')->name('PenilaianQiraah');

        Route::get('tambah', 'tambahPeserta')->name('Peserta.tambahPeserta');
        Route::post('tambah', 'simpan')->name('Peserta.simpan');
        Route::get('edit/{id}', 'edit')->name('barang.edit');
        Route::post('edit/{id}', 'update')->name('barang.tambah.update');
        Route::get('hapus/{id}', 'hapus')->name('barang.hapus');
    });
    Route::controller(PenggunaController::class)->prefix('Pengguna')->group(function () {
        Route::get('', 'tampilPengguna')->name('indexPengguna');
        Route::get('tambah', 'tambah')->name('Pengguna.tambah');
        Route::post('pengguna/tambah', 'simpan')->name('Pengguna.simpan');

        Route::get('edit/{id}', 'edit')->name('Pengguna.edit');
        Route::post('edit/{id}', 'update')->name('Pengguna.tambah.update');
        Route::get('hapus/{id}', 'hapus')->name('Pengguna.hapus');
    });
});


