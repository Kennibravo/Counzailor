<?php

return [
    'defaults' => [
        'guard' => 'counsellor',
        'passwords' => 'counsellees',
    ],

    'guards' => [
        'counsellor' => [
            'driver' => 'jwt',
            'provider' => 'counsellors',
        ],

        'counsellee' => [
            'driver' => 'jwt',
            'provider' => 'counsellees',
        ],


    ],

    'providers' => [
        'counsellors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Counsellor::class,
        ],

        'counsellees' => [
            'driver' => 'eloquent',
            'model' => App\Models\Counsellee::class,
        ],

    ],

];
