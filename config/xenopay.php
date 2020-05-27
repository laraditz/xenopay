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
    | Default account
    |--------------------------------------------------------------------------
    |
    | This details are used for xenopay authentication. If not set then need to send as payload on 
    |
    */
    'email' => env('XENOPAY_EMAIL'),

    'password' => env('XENOPAY_PASSWORD'),

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
