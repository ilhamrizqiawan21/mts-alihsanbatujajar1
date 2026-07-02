<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KebersihanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KeterlambatanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return session()->has('user_id')
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Auth routes for legacy session-based login
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['web','legacy.auth'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::resource('siswa', SiswaController::class)->parameters(['siswa' => 'siswa']);
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('izin', [IzinController::class, 'store'])->name('izin.store');
    Route::get('kebersihan', [KebersihanController::class, 'index'])->name('kebersihan.index');
    Route::post('kebersihan', [KebersihanController::class, 'store'])->name('kebersihan.store');
    Route::get('keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::post('prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('pengaturan', [PengaturanController::class, 'store'])->name('pengaturan.store');
});
