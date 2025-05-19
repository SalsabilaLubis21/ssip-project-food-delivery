<?php

return [
    'defaults' => [
        'guard' => 'web', // Default guard remains 'web'
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [ // Guard for regular users
            'driver' => 'session',
            'provider' => 'users', 
        ],

        'driver' => [ // FIX: This was the problem - guard name needs to match usage in controller
            'driver' => 'session',
            'provider' => 'drivers',
        ],

        'restaurant' => [
            'driver' => 'session',
            'provider' => 'restaurants',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        'restaurants' => [
            'driver' => 'eloquent',
            'model' => App\Models\Restaurant::class,
        ],
        'drivers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Driver::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'restaurants' => [
            'provider' => 'restaurants',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'drivers' => [
            'provider' => 'drivers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];