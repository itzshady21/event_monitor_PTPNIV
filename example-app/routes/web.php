<?php

use Illuminate\Support\Facades\Route;
use App\Models\EventModel;
use Carbon\Carbon;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventReportController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\KaryawanAksesController;
use App\Http\Controllers\JadwalPelatihanController;
use App\Http\Controllers\BagsdmController;



Route::get('/riwayat-pelatihan', [JadwalPelatihanController::class, 'riwayatPelatihan'])
    ->middleware('karyawan')
    ->name('riwayat.pelatihan');

// Default route
Route::get('/', function () {
    return view('welcome');
});

// Login & Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    
    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::get('/dashboard-bagsdm', [BagsdmController::class, 'index'])
    ->middleware(['bagsdm'])
    ->name('dashboard.bagsdm');

Route::get('/bagsdm/form-data-peserta', [BagsdmController::class, 'formDataPeserta'])->name('formDataPeserta');
Route::get('bagsdm/form-data-karyawan', [BagsdmController::class, 'formDataKaryawan'])->name('formDataKaryawan');
Route::get('/bagsdm/formPelatihan', [BagsdmController::class, 'showPelatihan'])->name('bagsdm.formPelatihan');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Karyawan Dashboard
Route::get('/dashboard-karyawan', [KaryawanAksesController::class, 'dashboard'])
    ->middleware('karyawan')
    ->name('dashboard.karyawan');

// Group routes with auth middleware
Route::middleware('auth')->group(function () {

    /** ---------------- Pelatihan ---------------- */
    Route::get('/formPelatihan', [PelatihanController::class, 'index'])->name('formPelatihan');
    Route::post('/formPelatihan/store', [PelatihanController::class, 'store'])->name('formPelatihan.store');
    Route::post('/formPelatihan/update/{id}', [PelatihanController::class, 'update'])->name('formPelatihan.update');
    Route::delete('/formPelatihan/delete/{id}', [PelatihanController::class, 'destroy'])->name('formPelatihan.destroy');

    /** ---------------- Bagian ---------------- */
    Route::get('/bagian', [BagianController::class, 'index'])->name('bagian.index');
    Route::post('/bagian/store', [BagianController::class, 'store'])->name('bagian.store');
    Route::put('/bagian/update/{id}', [BagianController::class, 'update'])->name('bagian.update');
    Route::delete('/bagian/delete/{id}', [BagianController::class, 'destroy'])->name('bagian.destroy');

    /** ---------------- Event ---------------- */
    Route::get('/formEvent', [EventController::class, 'formEvent'])->name('formEvent');
    Route::post('/formEvent/store', [EventController::class, 'storeEvent'])->name('formEvent.store');
    Route::put('/formEvent/update/{id}', [EventController::class, 'updateEvent'])->name('updateEvent');
    Route::get('/formEvent/edit/{id}', [EventController::class, 'editEvent'])->name('editEvent');
    Route::delete('/formEvent/delete/{id}', [EventController::class, 'deleteEvent'])->name('deleteEvent');
    Route::get('/formLihatData', [EventController::class, 'formLihatData'])->name('formLihatData');

    /** ---------------- Karyawan ---------------- */
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('listKaryawan');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('createKaryawan');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('storeKaryawan');
    Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('editKaryawan');
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('updateKaryawan');
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('destroyKaryawan');

    /** ---------------- API Pelatihan ---------------- */
    Route::get('/api/pelatihan/{id}', [PelatihanController::class, 'getPelatihanDetail'])->name('api.pelatihan.detail');
    // Jika memang Anda punya 2 fungsi berbeda untuk ambil data pelatihan, berikan nama unik
    Route::get('/api/pelatihan-data/{id}', [PelatihanController::class, 'getPelatihanById'])->name('api.pelatihan.data');
});

/** ---------------- Report Event ---------------- */
Route::get('/report', [EventReportController::class, 'index'])->name('report.index');
Route::get('/report/filter', [EventReportController::class, 'filter'])->name('report.filter');
Route::get('/report-event/export', [EventReportController::class, 'exportExcel'])->name('report.export');

// Halaman register pelatihan
Route::get('/register-pelatihan', [PelatihanController::class, 'showRegisterForm'])->name('register.form');

// Aksi register ke pelatihan
Route::post('/register-pelatihan/{id}', [PelatihanController::class, 'registerToPelatihan'])->name('register.pelatihan');

Route::get('/interface-karyawan', function () {
    $nik = session('karyawan_nik');
    $today = Carbon::today();

    $ongoing = EventModel::where('nik', $nik)
        ->whereDate('tgl_awal', '<=', $today)
        ->whereDate('tgl_akhir', '>=', $today)
        ->get();

    $finished = EventModel::where('nik', $nik)
        ->whereDate('tgl_akhir', '<', $today)
        ->get();

    $upcoming = EventModel::where('nik', $nik)
        ->whereDate('tgl_awal', '>', $today)
        ->get();

    return view('dashboard.interfaceKaryawan', compact('ongoing', 'finished', 'upcoming'));
})->name('interface.karyawan')->middleware('karyawan');



// web.php
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/formSertifikat', [EventController::class, 'formSertifikat'])->name('formSertifikat');
    Route::post('/upload-sertifikat/{id}', [EventController::class, 'uploadSertifikat'])->name('upload.sertifikat');
    Route::post('/edit-sertifikat/{id}', [EventController::class, 'editSertifikat'])->name('edit.sertifikat');
});

Route::get('/pelatihan/{id}', [JadwalPelatihanController::class, 'index'])->name('pelatihan.index');

// Untuk melihat halaman sertifikat pelatihan yang sudah selesai
Route::get('/sertifikat', [JadwalPelatihanController::class, 'sertifikat'])->name('sertifikat.index');

// Untuk mengunduh sertifikat
Route::get('/sertifikat/download/{id}', [JadwalPelatihanController::class, 'downloadSertifikat'])->name('sertifikat.download');

Route::get('/report-event/export-pdf', [EventReportController::class, 'exportPDF'])->name('report.export.pdf');








