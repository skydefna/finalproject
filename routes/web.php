<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Akun\DashboardController as AkunDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtamaController;
use App\Http\Controllers\Akun\AkunController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Pengguna\PengajuanController;
use App\Http\Controllers\Admin\DataPengajuanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Teknisi\DataTeknisiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataAduanController;
use App\Http\Controllers\Akun\DataAduanController as AkunDataAduanController;
use App\Http\Controllers\Akun\DataSurveiController;
use App\Http\Controllers\Akun\PengajuanController as AkunPengajuanController;
use App\Http\Controllers\Auth\RegistrasiController as AuthRegistrasiController;
use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboardController;
use App\Http\Controllers\Teknisi\PengajuanController as TeknisiPengajuanController;
use App\Http\Controllers\Pengguna\DashboardController as PenggunaDashboardController;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\DataTeknisiController as PimpinanDataTeknisiController;
use App\Http\Controllers\Pimpinan\DataPengajuanController as PimpinanDataPengajuanController;
use App\Http\Controllers\Pimpinan\DataSurveiController as PimpinanDataSurveiController;
use App\Http\Controllers\Teknisi\DataAduanController as TeknisiDataAduanController;

Route::get('/', [UtamaController::class, 'beranda'])->name('beranda');

Route::get('/auth/login', [LoginController::class, 'index'])->name('login');
Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('login.submit');;

Route::get('/auth/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/auth/lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/auth/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/auth/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/auth/buatpassword', [PasswordController::class, 'create'])->name('password.create');
    Route::post('/auth/buatpassword', [PasswordController::class, 'store'])->name('password.store');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/auth/registrasi', [AuthRegistrasiController::class, 'daftar'])->name('daftar.akun');
Route::post('/auth/registrasi', [AuthRegistrasiController::class, 'submit'])->name('daftar.submit');

Route::middleware(['auth'])->post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:tamu'])->group(function () {
    Route::get('/beranda', [PenggunaDashboardController::class,'beranda'])->name('tamu.beranda');
    Route::get('/pengajuan', [PenggunaDashboardController::class,'menu'])->name('tamu.pengajuan');
    Route::PUT('/pengajuan/submit', [PengajuanController::class,'submit'])->name('tamu.submit');
    Route::get('/api/desakelurahan', [PengajuanController::class, 'getDesa']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/utama', [AdminDashboardController::class,'beranda'])->name('admin.beranda');
    Route::get('/data-admin/visual', [AdminDashboardController::class,'visual'])->name('admin.keseluruhan.visual');
    Route::get('/data-admin/tabel', [AdminDashboardController::class,'tabel'])->name('admin.keseluruhan.tabel');
    Route::get('/data-admin/pengajuan', [AdminDashboardController::class,'pengajuan'])->name('admin.pengajuan');
    Route::PUT('/data-pengajuan/{id}/edit', [DataPengajuanController::class, 'edit'])->name('admin.update');
    Route::get('/data-admin/aduan', [DashboardController::class, 'aduan'])->name('admin.aduan');
    Route::get('/get-lokasi-by-pengajuan/{id}', [DataAduanController::class, 'getLokasiByPengajuan']);
    Route::PUT('/submit-admin/aduan', [DataAduanController::class,'buat'])->name('admin.buat');
    Route::PUT('/data-aduan/{id}/edit', [DataAduanController::class, 'update'])->name('admin.edit');
    Route::delete('/data-admin/aduan/hapus/{id}', [DataAduanController::class, 'hapus'])->name('admin.delete');
    Route::get('/pengajuan/export', [DataPengajuanController::class, 'export'])->name('pengajuan.export');
    Route::get('/get-desa/{kecamatan_id}', [DataPengajuanController::class, 'getDesa']);
    Route::patch('/pengajuan/{id}/toggle-status', [DataPengajuanController::class, 'toggleStatusAdmin'])->name('admin.toggleStatus');
    Route::get('/data-admin/teknisi', [AdminDashboardController::class,'teknisi'])->name('admin.teknisi');
    Route::POST('/data-admin/{id}/status', [DataPengajuanController::class, 'updateStatus'])->name('admin.updateStatus');
    Route::delete('/data-admin/pengajuan/hapus/{id}', [DataPengajuanController::class, 'hapus'])->name('admin.hapus');
});

Route::middleware(['auth', 'role:pimpinan'])->group(function(){
    Route::get('/dashboard', [PimpinanDashboardController::class, 'beranda'])->name('pimpinan.beranda');
    Route::get('/data-utama/visual', [PimpinanDashboardController::class,'visual'])->name('pimpinan.keseluruhan.visual');
    Route::get('/data-utama/tabel', [PimpinanDashboardController::class,'tabel'])->name('pimpinan.keseluruhan.tabel');
    Route::get('/data-utama/pengajuan', [PimpinanDashboardController::class, 'pengajuan'])->name('pimpinan.pengajuan');
    Route::get('/survei-data', [PimpinanDashboardController::class, 'survei'])->name('survei.pimpinan');
    Route::post('/data-utama/survei/{id}/status', [PimpinanDataSurveiController::class, 'updateStatus'])->name('pengajuan.status.update');
    Route::get('/data-utama/teknisi', [PimpinanDataTeknisiController::class, 'teknisi'])->name('pimpinan.teknisi');
    Route::get('/data-aduan', [PimpinanDashboardController::class, 'aduan'])->name('aduan.pimpinan');
});

Route::middleware(['auth', 'role:teknisi'])->group(function(){
    Route::get('/home', [TeknisiDashboardController::class, 'beranda'])->name('teknisi.beranda');
    Route::get('/data/visual', [TeknisiDashboardController::class,'visual'])->name('teknisi.keseluruhan.visual');
    Route::get('/data/tabel', [TeknisiDashboardController::class,'tabel'])->name('teknisi.keseluruhan.tabel');
    Route::get('/data/pengajuan', [TeknisiPengajuanController::class, 'pengajuan'])->name('teknisi.pengajuan');
    Route::get('/pengajuan/excel', [TeknisiPengajuanController::class, 'export'])->name('excel');
    Route::get('/data/aduan', [TeknisiDataAduanController::class, 'aduan'])->name('aduan.teknisi');
    Route::put('/teknisi/aduan/status/{id}', [TeknisiDataAduanController::class, 'updateStatus'])->name('aduan.updateStatus');
    Route::get('/data/survei', [TeknisiDashboardController::class, 'survei'])->name('teknisi.survei');
    Route::get('/data/teknisi', [TeknisiDashboardController::class, 'teknisi'])->name('teknisi.data');
    Route::put('/teknisi/update/{id}', [DataTeknisiController::class, 'update'])->name('update.data');
    Route::get('/teknisi/lokasi/{id}', [DataTeknisiController::class, 'getLokasi']);
    Route::PUT('/data/submit', [DataTeknisiController::class,'submit'])->name('teknisi.submit');
    Route::get('/download/{filename}', [DataTeknisiController::class, 'download'])->name('download.file');
    Route::delete('/data/pemasangan/{id}', [DataTeknisiController::class, 'delete'])->name('hapus.data');
});

Route::middleware(['auth', 'role:super admin'])->group(function(){
    Route::get('/menu/visual', [AkunDashboardController::class,'visual'])->name('akun.keseluruhan.visual');
    Route::get('/menu/tabel', [AkunDashboardController::class,'tabel'])->name('akun.keseluruhan.tabel');
    Route::get('/menu/pengajuan', [AkunDashboardController::class,'pengajuan'])->name('akun.pengajuan');
    Route::PUT('/menusubmit-pengajuan', [AkunPengajuanController::class,'create'])->name('akun.create');
    Route::get('/pengajuan/{id}/edit', [AkunPengajuanController::class, 'showEditForm'])->name('pengajuan.update');
    Route::PUT('/pengajuan/{id}', [AkunPengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::get('/api/desa', [AkunPengajuanController::class, 'getDesa']);
    Route::patch('/pengajuan/{id}/status', [AkunPengajuanController::class, 'toggleStatus'])->name('pengajuan.toggleStatus');
    Route::get('/survei-menu', [AkunDashboardController::class, 'survei'])->name('survei.akun');
    Route::PUT('/menusubmit-survei', [DataSurveiController::class,'create'])->name('survei.create');
    Route::PUT('/survei/{id}/edit', [DataSurveiController::class, 'update'])->name('survei.edit');
    Route::delete('/survei/hapus/{id}', [DataSurveiController::class,'hapus'])->name('survei.hapus');
    Route::get('/pengajuan/data/{id}', [DataSurveiController::class, 'getData']);
    Route::get('/aduan-menu', [AkunDashboardController::class, 'aduan'])->name('aduan.akun');
    Route::get('/getpengajuan/{id}', [AkunDataAduanController::class, 'getPengajuan']);
    Route::PUT('/submit-menu/aduan', [AkunDataAduanController::class,'buat'])->name('aduan.buat');
    Route::PUT('/menu-aduan/{id}/edit', [AkunDataAduanController::class, 'update'])->name('aduan.edit');
    Route::delete('/data-aduan/aduan/hapus/{id}', [AkunDataAduanController::class, 'hapus'])->name('aduan.delete');
    Route::get('/menu/teknisi', [AkunDashboardController::class,'teknisi'])->name('akun.teknisi');
    Route::get('/menu/data_akun', [AkunController::class,'akun'])->name('akun.data_akun');
    Route::put('/akun/edit/{id}', [AkunController::class, 'edit'])->name('akun.edit');
    Route::delete('/menu/data_akun/{id}', [AkunController::class, 'hapus'])->name('akun.hapus');
    Route::PUT('/menu/submit-akun', [AkunController::class,'submit'])->name('akun.submit');
    Route::delete('/menu/pengajuan/hapus/{id}', [AkunPengajuanController::class, 'delete'])->name('pengajuan.hapus');
});

