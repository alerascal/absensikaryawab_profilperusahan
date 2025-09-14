<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PegawaiPengajuanController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PegawaiAttendanceController;
use Illuminate\Http\Request;
/*
    ========================================================
    👋 Halo, saya Moh Sahrul Alam Syah
    - Developer Laravel
    - Penawaran jasa pembuatan website & aplikasi berbasis web
    - Hubungi saya: 082220668915 (WhatsApp)
    ========================================================
    */
// Halaman home
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Biometric login
Route::get('/login/biometric/{type}', [AuthController::class, 'biometricLogin'])->name('login.biometric');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
});
Route::middleware(['auth'])->group(function () {
    // Route untuk halaman kamera
    Route::get('/attendance/camera', [AttendanceController::class, 'attendanceCameraPage'])
        ->name('attendance.camera.page');

    // Route untuk submit absensi kamera (gabung jadi satu)
    Route::post('/attendance/camera/submit', [AttendanceController::class, 'cameraAttendance'])
        ->name('attendance.camera.submit');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/locations', [AttendanceController::class, 'locations'])->name('admin.locations.index');
    Route::get('/locations/create', [AttendanceController::class, 'createLocation'])->name('admin.locations.create');
    Route::post('/locations/store', [AttendanceController::class, 'storeLocation'])->name('admin.locations.store');
    Route::get('/locations/{id}/edit', [AttendanceController::class, 'editLocation'])->name('admin.locations.edit');
    Route::put('/locations/{id}', [AttendanceController::class, 'updateLocation'])->name('admin.locations.update');
    Route::delete('/locations/{id}', [AttendanceController::class, 'destroyLocation'])->name('admin.locations.destroy');
});
Route::get('/panduan', function () {
    return view('guide.index');
})->name('guide.index');

// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {


    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');

    // Kelola Pegawai
    Route::get('/pegawai', [AdminController::class, 'kelolaPegawai'])->name('pegawai');
    Route::post('/pegawai/tambah', [AdminController::class, 'addEmployee'])->name('pegawai.tambah');

    // Absensi biasa (admin)
    Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])->name('attendance.show');

    Route::post('/absensi/mark', [AdminController::class, 'markAttendance'])->name('absensi.mark');
    // Laporan
    Route::get('/laporan', [AdminController::class, 'viewReports'])->name('laporan');

    // Export
    Route::get('/export', [AdminController::class, 'exportData'])->name('export');

    // API untuk chart dan statistik
    Route::get('/chart/weekly', [AdminController::class, 'weeklyChart'])->name('chart.weekly');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('departments', DepartmentController::class);
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/attendance/download', [AttendanceController::class, 'download'])->name('attendance.download');
    // ✅ Tambahin ini
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');

    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])
        ->name('attendance.show');
    // route destroy per absensi
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])
        ->name('admin.attendance.destroy');
    Route::get('/attendance/{id}/photo', [AttendanceController::class, 'photo'])
        ->name('admin.attendance.photo');
    Route::delete('/admin/attendance/destroy-all', [AttendanceController::class, 'destroyAll'])->name('admin.attendance.destroyAll');

    Route::get('/attendance/report/download/{date}', [AttendanceController::class, 'downloadPdf'])->name('attendance.report.download');
    Route::get('/reports/monthly/pdf', [AttendanceController::class, 'monthlyPdf'])->name('reports.monthly.pdf');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('employees', EmployeeController::class);
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/attendance/download', [AttendanceController::class, 'download'])
        ->name('admin.attendance.download');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('schedules', ScheduleController::class);
});
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('shifts', \App\Http\Controllers\Admin\ShiftController::class);
});
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
    Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');

    Route::get('/other', [ReportController::class, 'other'])->name('other');
    Route::post('/submit', [ReportController::class, 'submit'])->name('submit'); // <- perbaiki di sini
});
// Dashboard Pegawai
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->as('pegawai.')->group(function () {
    Route::get('dashboard', [AttendanceController::class, 'pegawaiDashboard'])->name('dashboard');

    Route::get('attendance', [PegawaiAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/camera', [PegawaiAttendanceController::class, 'cameraPage'])->name('attendance.camera');
    Route::post('attendance/camera', [PegawaiAttendanceController::class, 'cameraAttendance'])->name('attendance.camera.store');
    Route::get('attendance/history', [PegawaiAttendanceController::class, 'history'])->name('attendance.history');

    // Jadwal pegawai
    Route::get('schedules/{user}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::get('pengajuan', [PegawaiPengajuanController::class, 'index'])->name('pengajuan.index');

    // Form buat pengajuan baru
    Route::get('pengajuan/create', [PegawaiPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('pengajuan', [PegawaiPengajuanController::class, 'store'])->name('pengajuan.store');

    // Detail pengajuan
    Route::get('pengajuan/{pengajuan}', [PegawaiPengajuanController::class, 'show'])->name('pengajuan.show');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('pengajuan', PengajuanController::class)->names('admin.pengajuan');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::put('/pengajuan/{id}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::put('/pengajuan/{id}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/check-leave-status', [AttendanceController::class, 'checkLeaveStatus'])->name('check.leave.status');
});
Route::get('/test-location', function (Request $request) {
    $locationService = app(\App\Services\LocationService::class);

    // contoh koordinat
    $request->merge([
        'latitude' => -6.8695717,
        'longitude' => 109.1251033,
        'accuracy' => 20,
    ]);

    try {
        // gunakan method testLocation yang sudah ada
        $result = $locationService->testLocation($request);
        return response()->json($result);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
