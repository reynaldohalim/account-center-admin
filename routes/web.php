<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Data Karyawan
    Route::get('data-karyawan', [DashboardController::class, 'data_karyawan']);
    Route::get('/data-karyawan/{nip}', [DashboardController::class, 'viewDetails'])->name('data_karyawan.details');
    Route::get('/absensi/detail/{type}/{id}/{nip}', [DashboardController::class, 'getDetail'])->name('absensi.detail');
    Route::get('/fetch-all-karyawans/{divisi}', [DashboardController::class, 'fetchAllKaryawans']);
    Route::get('/search-karyawan', [DashboardController::class, 'searchKaryawan'])->name('search.karyawan');
    Route::put('/data-karyawan/{nip}', [DashboardController::class, 'update'])->name('data_karyawan.update');
    Route::put('/data-keluarga/{id}', [DashboardController::class, 'updateKeluarga'])->name('data_keluarga.update');
    Route::put('/pendidikan/{id}', [DashboardController::class, 'updatePendidikan'])->name('pendidikan.update');
    Route::put('/bahasa/{id}', [DashboardController::class, 'updateBahasa'])->name('bahasa.update');
    Route::put('/organisasi/{id}', [DashboardController::class, 'updateOrganisasi'])->name('organisasi.update');
    Route::post('/pengalamankerja/{id}', [DashboardController::class, 'updatePengalamanKerja'])->name('pengalamankerja.update');

    //Libur Karyawan
    Route::get('pengaturan-libur', [DashboardController::class, 'pengaturan_libur']);
    Route::post('/libur-karyawan', [DashboardController::class, 'storeLiburKaryawan']);
    Route::get('/fetch-holidays', [DashboardController::class, 'fetchHolidays']);
    Route::delete('/libur-karyawan/{tgl}', [DashboardController::class, 'destroyLiburKaryawan']);
    Route::get('/libur-karyawan', [DashboardController::class, 'getLiburKaryawan']);

    //Pengajuan pembaruan
    Route::get('pengajuan-pembaruan', [DashboardController::class, 'pengajuan_pembaruan']);
    Route::patch('/approve-pembaruan/{id}', [DashboardController::class, 'approvePembaruan'])->name('approvePembaruan');
    Route::patch('/reject-pembaruan/{id}', [DashboardController::class, 'rejectPembaruan'])->name('rejectPembaruan');

    //Pengajuan izin
    Route::get('pengajuan-izin', [DashboardController::class, 'pengajuan_izin']);
    Route::get('/izin/data/{no_ijin}', [DashboardController::class, 'getIzin']);
    Route::post('/izin/approve1', [DashboardController::class, 'izin_approve1'])->name('izin.approve1');
    Route::post('/izin/approve2', [DashboardController::class, 'izin_approve2'])->name('izin.approve2');
    Route::post('/izin/reject', [DashboardController::class, 'izin_reject'])->name('izin.reject');

    Route::get('klasifikasi-karyawan', [DashboardController::class, 'klasifikasi_karyawan'])->name('klasifikasi-karyawan');

    Route::get('notifikasi', [DashboardController::class, 'notifikasi']);

    //IAM Manajemen Hak Akses
    Route::get('manajemen-hak-akses', [DashboardController::class, 'manajemen_hak_akses']);
    Route::post('/manajemen-hak-akses/searchAdmin', [DashboardController::class, 'searchAdmin'])->name('manajemen-hak-akses.search');
    Route::post('manajemen-hak-akses/fetchOptionsAdmin', [DashboardController::class, 'fetchOptionsAdmin'])->name('manajemen-hak-akses.fetchOptions');
    Route::post('/manajemen-hak-akses/addAdmin', [DashboardController::class, 'addAdmin'])->name('manajemen-hak-akses.add');
    Route::post('/manajemen-hak-akses/deleteAdmin', [DashboardController::class, 'deleteAdmin'])->name('manajemen-hak-akses.delete');


    //Ganti Password
    Route::get('ganti-password', [DashboardController::class, 'ganti_password']);
    Route::post('/admin/change-password', [DashboardController::class, 'changePassword'])->name('admin.change-password');
});
