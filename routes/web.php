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
    if (session()->has('user_id')) {
        return app(HomeController::class)->index();
    }

    return redirect()->route('login');
});

// Auth routes for legacy session-based login
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['web','legacy.auth'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('siswa/export-pdf', [SiswaController::class, 'exportPdf'])->name('siswa.exportPdf');
    Route::get('siswa/export-xlsx', [SiswaController::class, 'exportXlsx'])->name('siswa.exportXlsx');
    Route::resource('siswa', SiswaController::class)->parameters(['siswa' => 'siswa']);
    Route::get('kelas/export-pdf', [KelasController::class, 'exportPdf'])->name('kelas.exportPdf');
    Route::get('kelas/export-xlsx', [KelasController::class, 'exportXlsx'])->name('kelas.exportXlsx');
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('absensi/export-pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.exportPdf');
    Route::get('pelanggaran/export-pdf', [PelanggaranController::class, 'exportPdf'])->name('pelanggaran.exportPdf');
    Route::get('pelanggaran/export-xlsx', [PelanggaranController::class, 'exportXlsx'])->name('pelanggaran.exportXlsx');
    Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    Route::get('izin/export-pdf', [IzinController::class, 'exportPdf'])->name('izin.exportPdf');
    Route::get('izin/export-xlsx', [IzinController::class, 'exportXlsx'])->name('izin.exportXlsx');
    Route::get('izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('izin', [IzinController::class, 'store'])->name('izin.store');
    Route::get('izin/{izin}/edit', [IzinController::class, 'edit'])->name('izin.edit');
    Route::put('izin/{izin}', [IzinController::class, 'update'])->name('izin.update');
    Route::delete('izin/{izin}', [IzinController::class, 'destroy'])->name('izin.destroy');
    Route::get('kebersihan/export-pdf', [KebersihanController::class, 'exportPdf'])->name('kebersihan.exportPdf');
    Route::get('kebersihan/export-xlsx', [KebersihanController::class, 'exportXlsx'])->name('kebersihan.exportXlsx');
    Route::get('kebersihan', [KebersihanController::class, 'index'])->name('kebersihan.index');
    Route::post('kebersihan', [KebersihanController::class, 'store'])->name('kebersihan.store');
    Route::get('kebersihan/{kebersihan}/edit', [KebersihanController::class, 'edit'])->name('kebersihan.edit');
    Route::put('kebersihan/{kebersihan}', [KebersihanController::class, 'update'])->name('kebersihan.update');
    Route::delete('kebersihan/{kebersihan}', [KebersihanController::class, 'destroy'])->name('kebersihan.destroy');
    Route::get('keterlambatan/export-pdf', [KeterlambatanController::class, 'exportPdf'])->name('keterlambatan.exportPdf');
    Route::get('keterlambatan/export-xlsx', [KeterlambatanController::class, 'exportXlsx'])->name('keterlambatan.exportXlsx');
    Route::get('keterlambatan', [KeterlambatanController::class, 'index'])->name('keterlambatan.index');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->name('keterlambatan.store');
    Route::get('keterlambatan/{keterlambatan}/edit', [KeterlambatanController::class, 'edit'])->name('keterlambatan.edit');
    Route::put('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'update'])->name('keterlambatan.update');
    Route::delete('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'destroy'])->name('keterlambatan.destroy');
    Route::get('prestasi/export-pdf', [PrestasiController::class, 'exportPdf'])->name('prestasi.exportPdf');
    Route::get('prestasi/export-xlsx', [PrestasiController::class, 'exportXlsx'])->name('prestasi.exportXlsx');
    Route::get('prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::post('prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('prestasi/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
    Route::put('prestasi/{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('prestasi/{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('pengaturan', [PengaturanController::class, 'store'])->name('pengaturan.store');
});
