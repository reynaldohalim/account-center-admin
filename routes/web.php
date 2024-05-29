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
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Data Karyawan
    Route::get('data-karyawan', [DashboardController::class, 'data_karyawan']);
    Route::get('/data-karyawan/{nip}', [DashboardController::class, 'viewDetails'])->name('data_karyawan.details');
    Route::get('/fetch-all-karyawans/{divisi}', [DashboardController::class, 'fetchAllKaryawans']);

    //Libur Karyawan
    Route::get('pengaturan-libur', [DashboardController::class, 'pengaturan_libur']);
    Route::post('/libur-karyawan', [DashboardController::class, 'storeLiburKaryawan']);
    Route::get('/fetch-holidays', [DashboardController::class, 'fetchHolidays']);
    Route::delete('/libur-karyawan/{tgl}', [DashboardController::class, 'destroyLiburKaryawan']);
    Route::get('/libur-karyawan', [DashboardController::class, 'getLiburKaryawan']);

    //Pengajuan pembaruan
    Route::get('pengajuan-pembaruan', [DashboardController::class, 'pengajuan_pembaruan']);
    Route::patch('/pembaruan/approve/{id}', [DashboardController::class, 'approvePembaruan'])->name('approvePembaruan');
    Route::patch('/pembaruan/reject/{id}', [DashboardController::class, 'rejectPembaruan'])->name('rejectPembaruan');

    //Pengajuan izin
    Route::get('pengajuan-izin', [DashboardController::class, 'pengajuan_izin']);
    Route::post('/izin/approve1', [DashboardController::class, 'izin_approve1'])->name('izin.approve1');
    Route::post('/izin/approve2', [DashboardController::class, 'izin_approve2'])->name('izin.approve2');
    Route::post('/izin/reject', [DashboardController::class, 'izin_reject'])->name('izin.reject');

    Route::get('klasifikasi-karyawan', [DashboardController::class, 'klasifikasi_karyawan']);
    Route::get('notifikasi', [DashboardController::class, 'notifikasi']);

    //IAM Manajemen Hak Akses
    Route::get('manajemen-hak-akses', [DashboardController::class, 'manajemen_hak_akses']);
    Route::post('/manajemen-hak-akses/search', [DashboardController::class, 'searchNip'])->name('search.nip');
    Route::post('/manajemen-hak-akses/add', [DashboardController::class, 'addOrUpdateAdmin'])->name('add.admin');
    Route::post('/fetch-jabatan', [DashboardController::class, 'fetchJabatan'])->name('fetch.jabatan');
    Route::post('/fetch-bagian', [DashboardController::class, 'fetchBagian'])->name('fetch.bagian');
    Route::post('/fetch-group', [DashboardController::class, 'fetchGroup'])->name('fetch.group');
});


