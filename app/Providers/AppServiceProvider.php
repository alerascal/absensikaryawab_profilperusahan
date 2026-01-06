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

    }

    public function boot(): void
    {
        
    }
}
