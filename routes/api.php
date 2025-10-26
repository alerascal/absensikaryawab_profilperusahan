<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group.
|
*/

Route::middleware(['auth:sanctum', 'force.json'])->group(function () {
    // API untuk absensi kamera
    Route::post('/attendance/camera', [AttendanceController::class, 'cameraAttendance'])
        ->name('attendance.camera')
        ->middleware('throttle:60,1');

    // API untuk melihat foto absensi
    Route::get('/attendance/{id}/photo', [AttendanceController::class, 'photo'])
        ->name('attendance.photo');

    // API untuk daftar karyawan
    Route::get('/employees', [AttendanceController::class, 'employees'])
        ->name('attendances.employees');

    // API untuk manajemen absensi
    Route::prefix('attendances')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('/', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/{id}', [AttendanceController::class, 'show'])->name('attendances.show');
        Route::put('/{id}', [AttendanceController::class, 'update'])->name('attendances.update');
        Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    });

    // Rute untuk admin
    Route::middleware(['role:admin'])->group(function () {
        // API untuk pengujian lokasi
        Route::post('/locations/test', [AttendanceController::class, 'testLocation'])
            ->name('locations.test')
            ->middleware('throttle:60,1');

        // API untuk pengujian lokasi dengan detail
        Route::post('/locations/test-enhanced', [AttendanceController::class, 'testLocationEnhanced'])
            ->name('locations.test-enhanced')
            ->middleware('throttle:60,1');

        // API untuk mendapatkan daftar lokasi
        Route::get('/locations', [AttendanceController::class, 'getLocationsApi'])
            ->name('locations.api');

        // API untuk detail lokasi
        Route::get('/locations/{id}', [AttendanceController::class, 'getLocationDetails'])
            ->name('locations.show');

        // API untuk top departemen
        Route::get('/departments/top', [DepartmentController::class, 'topDepartments'])
            ->name('departments.top');
    });
});

// Rute untuk pengujian lokasi tanpa autentikasi (untuk debugging)
Route::get('/test-location', function (Illuminate\Http\Request $request) {
    $locationService = app(\App\Services\LocationService::class);

    // Contoh koordinat untuk pengujian
    $request->merge([
        'latitude' => -6.8695717,
        'longitude' => 109.1251033,
        'accuracy' => 20,
    ]);

    try {
        $result = $locationService->testLocation($request);
        return response()->json($result);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('test.location');
Route::post('/attendance/camera/submit', [AttendanceController::class, 'checkLocation'])
    ->name('attendance.camera.submit')
    ->middleware('throttle:60,1');
