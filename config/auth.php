<?php

return [

    /*
    |----------------------------------------------------------------------
    | Authentication Defaults
    |----------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'mahasiswa', // Set the default guard directly here
        'passwords' => 'mahasiswa', // Set the default password broker directly here
    ],

    /*
    |----------------------------------------------------------------------
    | Authentication Guards
    |----------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | These guards define how users are authenticated via session.
    |
    */

    'guards' => [
        'mahasiswa' => [
            'driver' => 'session',
            'provider' => 'mahasiswa',
        ],
        'karyawan' => [
            'driver' => 'session',
            'provider' => 'karyawan',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | User Providers
    |----------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are retrieved from the database.
    |
    */

    'providers' => [
        'mahasiswa' => [
            'driver' => 'eloquent',
            'model' => App\Models\Mahasiswa::class, // Ensure this model exists
        ],
        'karyawan' => [
            'driver' => 'eloquent',
            'model' => App\Models\Karyawan::class, // Ensure this model exists
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Password Reset Configuration
    |----------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality.
    |
    */

    'passwords' => [
        'mahasiswa' => [
            'provider' => 'mahasiswa',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'karyawan' => [
            'provider' => 'karyawan',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
