<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\AttendanceService;
use App\Services\LocationService;
use App\Services\AttendanceReportService;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AttendanceService::class, function ($app) {
            return new AttendanceService($app->make(LocationService::class));
        });

        $this->app->singleton(LocationService::class, function ($app) {
            return new LocationService();
        });

        $this->app->singleton(AttendanceReportService::class, function ($app) {
            return new AttendanceReportService();
        });
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $date = Carbon::today()->toDateString();
            $attendanceCount = Cache::remember('attendance_count_' . $date, now()->addHours(1), function () {
                return app(AttendanceService::class)->getTodayAttendanceCount();
            });
            $scheduleCount = Cache::remember('schedule_count_' . $date, now()->addHours(1), function () {
                return app(AttendanceService::class)->getScheduleCount();
            });

            $view->with([
                'attendanceCount' => $attendanceCount,
                'scheduleCount' => $scheduleCount,
            ]);
        });
    }
}
