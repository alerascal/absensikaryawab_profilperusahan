<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Sistem Absensi'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    | Set to `false` in production for security.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. Set to "Asia/Jakarta"
    | for Indonesia (WIB).
    |
    */

    'timezone' => 'Asia/Jakarta',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'id'), // Bahasa Indonesia sebagai default
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => env('APP_FAKER_LOCALE', 'id_ID'), // Untuk data dummy lokal

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Attendance System Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration specific to the attendance system, including location
    | validation, GPS accuracy, and photo processing settings.
    |
    */

    'attendance' => [
        // Radius untuk validasi lokasi (meter)
        'default_radius' => env('ATTENDANCE_DEFAULT_RADIUS', 500), // Diperbesar dari 200m
        'min_radius' => env('ATTENDANCE_MIN_RADIUS', 50),
        'max_radius' => env('ATTENDANCE_MAX_RADIUS', 1000),

        // Default koordinat kantor DPRD Tegal sebagai fallback
        'default_location' => [
            'latitude' => env('ATTENDANCE_DEFAULT_LATITUDE', -6.8696),
            'longitude' => env('ATTENDANCE_DEFAULT_LONGITUDE', 109.1221),
            'name' => env('ATTENDANCE_DEFAULT_LOCATION_NAME', 'Kantor'),
        ],

        // Batas akurasi GPS (meter)
        'default_accuracy' => env('ATTENDANCE_DEFAULT_ACCURACY', 50),
        'max_accuracy' => env('ATTENDANCE_MAX_ACCURACY', 3000),
        'max_accuracy_buffer' => env('ATTENDANCE_MAX_ACCURACY_BUFFER', 500),

        // Cache untuk lokasi absensi (detik)
        'cache_ttl_locations' => env('ATTENDANCE_CACHE_TTL_LOCATIONS', 3600), // 1 jam

        // Pengaturan foto absensi
        'max_photo_size' => env('ATTENDANCE_MAX_PHOTO_SIZE', 5120), // 5MB
        'photo_compression_quality' => env('ATTENDANCE_PHOTO_COMPRESSION_QUALITY', 80), // 80% kualitas
        'photo_max_width' => env('ATTENDANCE_PHOTO_MAX_WIDTH', 800), // Maksimal lebar gambar
    ],

    /*
    |--------------------------------------------------------------------------
    | Memory Limit Configuration
    |--------------------------------------------------------------------------
    |
    | Suggested memory limit for PHP to avoid "Out of memory" errors.
    | Adjust in php.ini or .env as needed.
    |
    */

    'max_memory_limit' => env('APP_MAX_MEMORY_LIMIT', '256M'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class, // Pastikan ini ada

    /*
     * Package Service Providers...
     */
    Laravel\Sanctum\SanctumServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,

    /*
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
],


    'aliases' => [
        // ...
        'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
        'View' => Illuminate\Support\Facades\View::class, // Tambahkan ini
        // ...
    ],
];
