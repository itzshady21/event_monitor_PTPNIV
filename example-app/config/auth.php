<?php

return [

    'defaults' => [
        'guard' => 'web', // Atau bisa diganti 'karyawan' jika defaultnya untuk karyawan
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'karyawan' => [
            'driver' => 'session',
            'provider' => 'karyawans',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'karyawans' => [
            'driver' => 'eloquent',
            'model' => App\Models\Karyawan::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'karyawans' => [
            'provider' => 'karyawans',
            'table' => 'password_resets', // Bisa buat tabel baru jika ingin terpisah
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
