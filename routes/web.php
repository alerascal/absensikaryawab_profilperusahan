<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PegawaiAttendanceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Admin\ShiftController;

/*
    ========================================================
    👋 Halo, saya Moh Sahrul Alam Syah
    - Developer Laravel
    - Penawaran jasa pembuatan website & aplikasi berbasis web
    - Hubungi saya: 082220668915 (WhatsApp)
    ========================================================
*/

// ====================
// Public Routes
// ====================
Route::get('/', fn() => view('home'))->name('home');
Route::get('/panduan', fn() => view('guide.index'))->name('guide.index');

// ====================
// Authentication
// ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/login/biometric/{type}', [AuthController::class, 'biometricLogin'])->name('login.biometric');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================
// Authenticated Routes (All Users)
// ====================
Route::middleware('auth')->group(function () {

    // Profile / Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // ====================
    // Pengajuan (Semua User: Pegawai & Admin)
    // ====================
    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/my', [PengajuanController::class, 'myRequests'])->name('my');
        Route::get('/create', [PengajuanController::class, 'create'])->name('create');
        Route::post('/', [PengajuanController::class, 'store'])->name('store');
        Route::get('/{pengajuan}', [PengajuanController::class, 'show'])->name('show');
        Route::get('/{pengajuan}/edit', [PengajuanController::class, 'edit'])->name('edit');
        Route::put('/{pengajuan}', [PengajuanController::class, 'update'])->name('update');

        // Hapus pengajuan - bisa diakses pegawai (dibatasi di controller) dan admin
        Route::delete('/{pengajuan}', [PengajuanController::class, 'destroy'])->name('destroy');
    });

    // ====================
    // Absensi & Jadwal Pegawai
    // ====================
    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiController::class, 'pegawaiDashboard'])->name('dashboard');

        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [PegawaiAttendanceController::class, 'index'])->name('index');
            Route::get('/camera', [PegawaiAttendanceController::class, 'cameraPage'])->name('camera');
            Route::post('/camera', [PegawaiAttendanceController::class, 'cameraAttendance'])->name('camera.store');
            Route::get('/history', [PegawaiAttendanceController::class, 'history'])->name('history');
            Route::get('/export/{type}', [AttendanceController::class, 'myAttendanceExport'])->name('export');
        });

        Route::get('/schedules/{user}', [ScheduleController::class, 'show'])->name('schedules.show');
    });

    // ====================
    // Absensi Umum
    // ====================
    Route::prefix('attendance')->group(function () {
        Route::get('/camera', [AttendanceController::class, 'attendanceCameraPage'])->name('attendance.camera.page');
        Route::get('/check-schedule', [AttendanceController::class, 'checkSchedule'])->name('attendance.check-schedule');
        Route::post('/camera', [AttendanceController::class, 'cameraAttendance'])->name('attendance.camera.submit');
        Route::post('/check-location', [AttendanceController::class, 'checkLocation'])->name('check-location');
        Route::post('/camera-attendance', [AttendanceController::class, 'cameraAttendance'])->name('camera-attendance');
        Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.my');
        Route::get('/check-leave-status', [AttendanceController::class, 'checkLeaveStatus'])->name('check.leave.status');
    });

    // ====================
    // Laporan
    // ====================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/other', [ReportController::class, 'other'])->name('other');
        Route::post('/update-status/{id}', [ReportController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/attendance/download/{date}', [ReportController::class, 'downloadAttendance'])->name('attendance.download');
        Route::get('/monthly/pdf', [ReportController::class, 'monthlyPdf'])->name('monthly.pdf');
    });
});

// ====================
// Admin Only Routes
// ====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
        Route::post('/manual-attendance', [AdminController::class, 'manualAttendance'])->name('admin.manual-attendance');
        Route::post('/absensi/mark', [AdminController::class, 'markAttendance'])->name('absensi.mark');

        // Kelola Pegawai
        Route::get('/pegawai', [AdminController::class, 'kelolaPegawai'])->name('pegawai');
        Route::post('/pegawai/tambah', [AdminController::class, 'addEmployee'])->name('pegawai.tambah');

        // Absensi Admin
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
            Route::post('/', [AttendanceController::class, 'store'])->name('store');
            Route::get('/{id}', [AttendanceController::class, 'show'])->name('show');
            Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/photo', [AttendanceController::class, 'photo'])->name('photo');
            Route::delete('/destroy-all', [AttendanceController::class, 'destroyAll'])->name('destroyAll');
            Route::get('/export', [AttendanceController::class, 'export'])->name('export');
            Route::get('/download', [AttendanceController::class, 'download'])->name('download');
            Route::get('/report/download/{date}', [AttendanceController::class, 'downloadPdf'])->name('report.download');
            Route::get('/monthly/pdf', [AttendanceController::class, 'monthlyPdf'])->name('reports.monthly.pdf');
        });

        // Lokasi Absensi
        Route::prefix('locations')->name('locations.')->group(function () {
            Route::get('/', [AttendanceController::class, 'locations'])->name('index');
            Route::get('/create', [AttendanceController::class, 'createLocation'])->name('create');
            Route::post('/', [AttendanceController::class, 'storeLocation'])->name('store');
            Route::get('/{location}/edit', [AttendanceController::class, 'editLocation'])->name('edit');
            Route::put('/{location}', [AttendanceController::class, 'updateLocation'])->name('update');
            Route::delete('/{location}', [AttendanceController::class, 'destroyLocation'])->name('destroy');
        });

        // Resource Routes
        Route::resource('departments', DepartmentController::class);
        Route::get('/departments/top', [DepartmentController::class, 'topDepartments'])->name('departments.top');

        Route::resource('employees', EmployeeController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('shifts', ShiftController::class);

        // Pengajuan Admin
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [PengajuanController::class, 'index'])->name('index');
            Route::post('/{id}/approve', [PengajuanController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [PengajuanController::class, 'reject'])->name('reject');

            // Admin bisa hapus pengajuan kapan saja (termasuk yang sudah diproses)
            Route::delete('/{pengajuan}', [PengajuanController::class, 'destroy'])->name('destroy');
        });

        // Laporan & Chart
        Route::get('/laporan', [AdminController::class, 'viewReports'])->name('laporan');
        Route::get('/export', [AdminController::class, 'exportData'])->name('export');
        Route::get('/chart/weekly', [AdminController::class, 'weeklyChart'])->name('chart.weekly');
    });
