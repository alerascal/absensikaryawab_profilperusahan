<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\DepartmentController;


Route::prefix('attendances')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/{id}', [AttendanceController::class, 'show'])->name('attendances.show');
    Route::put('/{id}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
});
Route::get('/admin/departments/top', [DepartmentController::class, 'topDepartments'])
     ->name('admin.departments.top');

// Endpoint untuk daftar karyawan
Route::get('/employees', [AttendanceController::class, 'employees'])->name('attendances.employees');
Route::get('/locations/api', [AttendanceController::class, 'getLocationsApi'])->name('locations.api');
Route::middleware(['auth:sanctum', 'force.json'])->post('/attendance/camera', [AttendanceController::class, 'cameraAttendance'])->name('attendance.camera');