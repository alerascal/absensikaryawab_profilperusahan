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
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\ProfileController;

/*
    ========================================================
    👋 Halo, saya Moh Sahrul Alam Syah
    - Developer Laravel
    - Penawaran jasa pembuatan website & aplikasi berbasis web
    - Hubungi saya: 082220668915 (WhatsApp)
    ========================================================
*/

// ---------------------
// Halaman Public
// ---------------------
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/panduan', function () {
    return view('guide.index');
})->name('guide.index');

// ---------------------
// Auth
// ---------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/login/biometric/{type}', [AuthController::class, 'biometricLogin'])->name('login.biometric');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------
// Middleware Auth
// ---------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/settings', [ProfileController::class, 'index'])->name('settings.index');
    Route::get('/settings/edit', [ProfileController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/update', [ProfileController::class, 'update'])->name('settings.update');
    Route::delete('/settings/destroy', [ProfileController::class, 'destroy'])->name('settings.destroy');


    // ---------------------
    // Absensi Pegawai
    // ---------------------
    Route::get('/attendance/camera', [AttendanceController::class, 'attendanceCameraPage'])
        ->name('attendance.camera.page');
    Route::get('/attendance/check-schedule', [AttendanceController::class, 'checkSchedule'])
        ->name('attendance.check-schedule');
    Route::post('/attendance/camera', [AttendanceController::class, 'cameraAttendance'])->name('attendance.camera.submit');
    Route::post('/check-location', [AttendanceController::class, 'checkLocation'])->name('check-location');
    Route::post('/camera-attendance', [AttendanceController::class, 'cameraAttendance'])->name('camera-attendance');
    Route::get('/attendance/my-attendance', [AttendanceController::class, 'myAttendance'])
        ->name('attendance.my');
    Route::get('/check-leave-status', [AttendanceController::class, 'checkLeaveStatus'])
        ->name('check.leave.status');
    // routes/web.php
    Route::get('/pegawai/attendance/export/{type}', [AttendanceController::class, 'myAttendanceExport'])
        ->name('pegawai.attendance.export');



    // ---------------------
    // Dashboard & Pengajuan Pegawai
    // ---------------------
    Route::prefix('pegawai')->name('pegawai.')->middleware('auth')->group(function () {
        Route::get('/dashboard', [AttendanceController::class, 'pegawaiDashboard'])->name('dashboard');

        // Attendance
        Route::get('/attendance', [PegawaiAttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/camera', [PegawaiAttendanceController::class, 'cameraPage'])->name('attendance.camera');
        Route::post('/attendance/camera', [PegawaiAttendanceController::class, 'cameraAttendance'])->name('attendance.camera.store');
        Route::get('/attendance/history', [PegawaiAttendanceController::class, 'history'])->name('attendance.history');

        // Jadwal
        Route::get('/schedules/{user}', [ScheduleController::class, 'show'])->name('schedules.show');

        // Pengajuan
        Route::get('/pengajuan', [PegawaiPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/create', [PegawaiPengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan', [PegawaiPengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/pengajuan/{pengajuan}', [PegawaiPengajuanController::class, 'show'])->name('pengajuan.show');
    });

    // ---------------------
    // Laporan
    // ---------------------
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/other', [ReportController::class, 'other'])->name('other');
        Route::post('/update-status/{id}', [ReportController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/attendance/download/{date}', [ReportController::class, 'downloadAttendance'])->name('attendance.download');
        Route::get('/monthly/pdf', [ReportController::class, 'monthlyPdf'])->name('monthly.pdf');
    });
});

// ---------------------
// Route Admin
// ---------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
    Route::post('/admin/manual-attendance', [AdminController::class, 'manualAttendance'])->name('admin.manual-attendance');

    // Pegawai
    Route::get('/pegawai', [AdminController::class, 'kelolaPegawai'])->name('pegawai');
    Route::post('/pegawai/tambah', [AdminController::class, 'addEmployee'])->name('pegawai.tambah');

    // Absensi
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance/{id}/photo', [AttendanceController::class, 'photo'])->name('attendance.photo');
    Route::delete('/attendance/destroy-all', [AttendanceController::class, 'destroyAll'])->name('attendance.destroyAll');
    Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
    Route::get('/attendance/download', [AttendanceController::class, 'download'])->name('attendance.download');
    Route::get('/attendance/report/download/{date}', [AttendanceController::class, 'downloadPdf'])->name('attendance.report.download');
    Route::get('/reports/monthly/pdf', [AttendanceController::class, 'monthlyPdf'])->name('reports.monthly.pdf');
    Route::post('/absensi/mark', [AdminController::class, 'markAttendance'])->name('absensi.mark');


    Route::get('/locations', [AttendanceController::class, 'locations'])->name('locations.index');
    Route::post('/locations', [AttendanceController::class, 'storeLocation'])->name('locations.store'); // Updated from store to storeLocation
    Route::get('/locations/create', [AttendanceController::class, 'createLocation'])->name('locations.create'); // Updated from create to createLocation
    Route::get('/locations/{location}/edit', [AttendanceController::class, 'editLocation'])->name('locations.edit'); // Updated from edit to editLocation
    Route::put('/locations/{location}', [AttendanceController::class, 'updateLocation'])->name('locations.update'); // Updated from update to updateLocation
    Route::delete('/locations/{location}', [AttendanceController::class, 'destroyLocation'])->name('locations.destroy');


    // Departemen
    Route::resource('departments', DepartmentController::class);
    Route::get('/departments/top', [DepartmentController::class, 'topDepartments'])->name('departments.top');

    // Karyawan
    Route::resource('employees', EmployeeController::class);

    // Jadwal
    Route::resource('schedules', ScheduleController::class);

    // Shift
    Route::resource('shifts', ShiftController::class);

    // Pengajuan Admin
    Route::resource('pengajuan', PengajuanController::class);
    Route::put('/pengajuan/{id}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::put('/pengajuan/{id}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');

    // Laporan
    Route::get('/laporan', [AdminController::class, 'viewReports'])->name('laporan');
    Route::get('/export', [AdminController::class, 'exportData'])->name('export');
    Route::get('/chart/weekly', [AdminController::class, 'weeklyChart'])->name('chart.weekly');
});
