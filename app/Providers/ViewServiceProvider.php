<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\AttendanceService;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $attendanceService = app(AttendanceService::class);

                $view->with(
                    'todayAttendanceCount',
                    $attendanceService->getTodayAttendanceCount(auth()->id())
                );
            }
        });
    }
}
