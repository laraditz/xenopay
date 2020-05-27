<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the service to make and API request.
    |
    */

    'url' => env('XENOPAY_URL', 'https://xenopay.asia/api/web/v1'),

    /*
    |--------------------------------------------------------------------------
    | API routes
    |--------------------------------------------------------------------------
    |
    | This routes is where all the api routes should be set.
    |
    */
    'routes' => [
        'auth' => [
            'login' => '/auth/login',
        ],
        'bill' => [
            'create' => '/bills/create',
            'view' => '/bills/:id',
        ],
    ],
];
