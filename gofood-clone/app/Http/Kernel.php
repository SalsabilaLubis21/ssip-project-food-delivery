<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

// --- IMPORT MIDDLEWARE KUSTOM ANDA DAN STANDAR YANG DIBUTUHKAN ---
use App\Http\Middleware\DriverMiddleware;         // Untuk alias 'auth.driver'
use App\Http\Middleware\PreventBackHistory;       // Untuk alias 'prevent-back-history'
use Illuminate\Auth\Middleware\RedirectIfAuthenticated; // Untuk alias 'guest'
// ---------------------------------------------------------------


class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Ini adalah middleware global standar Laravel
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        
        // Middleware global kustom lainnya (jika ada) dapat ditambahkan di sini
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
       
            'web' => [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\Session\Middleware\AuthenticateSession::class, // Mungkin ada atau tidak tergantung versi
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                // \Illuminate\Auth\Middleware\Authenticate::class, // Middleware 'auth' biasanya dipanggil di route atau controller
            ],
    
            // ... grup lainnya
        
        'api' => [
            // Middleware untuk grup 'api' standar
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Jika menggunakan Sanctum
            'throttle:api', // Throttle request API
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Mengganti parameter route dengan model Eloquent
            // Tambahkan middleware grup API kustom lainnya (jika ada) di sini
        ],
    ];

    /**
     * The application's route middleware aliases.
     *
     * The aliases are stored in the route middleware, but sometimes you may want
     * to group them or use them individually.
     *
     * @var array
     */
    protected $middlewareAliases = [ // <-- PASTIKAN MENGGUNAKAN NAMA properti INI
        // --- ALIAS MIDDLEWARE STANDAR ---
        'auth' => \App\Http\Middleware\Authenticate::class, // Alias standar 'auth' (menggunakan App\Http\Middleware\Authenticate)
        // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Alias standar opsional
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Alias standar
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Alias standar
        'guest' => RedirectIfAuthenticated::class, // Alias standar 'guest' (menggunakan RedirectIfAuthenticated yang diimpor)
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Alias standar
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Alias standar
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'check.role' => \App\Http\Middleware\CheckUserRole::class, // Alias standar


        // --- ALIAS MIDDLEWARE KUSTOM ANDA DITAMBAHKAN DI SINI ---
        'auth.driver' => DriverMiddleware::class,         // Alias kustom Anda
        'prevent-back-history' => PreventBackHistory::class, // Alias kustom Anda
        // Tambahkan alias middleware kustom lainnya (jika ada) di sini
        // 'nama_alias_anda' => \App\Http\Middleware\NamaMiddlewareAnda::class,
        // ---------------------------------------------------------------------
    ];

    // --- HAPUS ATAU KOMENTARI properti $routeMiddleware JIKA ADA ---
    // protected $routeMiddleware = []; // Hapus atau komentar baris ini jika ada
    // -------------------------------------------------------------
}