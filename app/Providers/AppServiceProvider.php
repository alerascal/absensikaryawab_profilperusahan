<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\AttendanceService;
use App\Services\LocationService;
use App\Services\AttendanceReportService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding services
       $this->app->singleton(AttendanceService::class, function ($app) {
    return new AttendanceService($app->make(LocationService::class));
});


        // Tambahkan binding untuk LocationService dan AttendanceReportService jika belum ada
        $this->app->singleton(LocationService::class, function ($app) {
            return new LocationService();
        });

        $this->app->singleton(AttendanceReportService::class, function ($app) {
            return new AttendanceReportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan variabel global ke semua view
        View::composer('*', function ($view) {
            $attendanceService = app(AttendanceService::class);

            $view->with([
                'attendanceCount' => $attendanceService->getTodayAttendanceCount(),
                'scheduleCount'   => $attendanceService->getScheduleCount(),
            ]);
        });
    }
}