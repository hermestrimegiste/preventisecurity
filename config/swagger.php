<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Swagger API Documentation
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration for Swagger API documentation.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | This value is the base URL for your API. This is used by Swagger to
    | generate the API documentation.
    |
    */

    'host' => env('APP_URL', 'http://localhost:8000'),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | This value is the version of your API. This is used by Swagger to
    | generate the API documentation.
    |
    */

    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | API Title
    |--------------------------------------------------------------------------
    |
    | This value is the title of your API. This is used by Swagger to
    | generate the API documentation.
    |
    */

    'title' => 'MediCare API Documentation',

    /*
    |--------------------------------------------------------------------------
    | API Description
    |--------------------------------------------------------------------------
    |
    | This value is the description of your API. This is used by Swagger to
    | generate the API documentation.
    |
    */

    'description' => 'API documentation for MediCare - A healthcare management system',

    /*
    |--------------------------------------------------------------------------
    | API Terms of Service
    |--------------------------------------------------------------------------
    |
    | This value is the terms of service URL for your API. This is used by
    | Swagger to generate the API documentation.
    |
    */

    'terms_of_service' => 'https://medicare.com/terms',

    /*
    |--------------------------------------------------------------------------
    | API Contact
    |--------------------------------------------------------------------------
    |
    | This value is the contact information for your API. This is used by
    | Swagger to generate the API documentation.
    |
    */

    'contact' => [
        'name' => 'API Support',
        'url' => 'https://medicare.com/support',
        'email' => 'support@medicare.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | API License
    |--------------------------------------------------------------------------
    |
    | This value is the license information for your API. This is used by
    | Swagger to generate the API documentation.
    |
    */

    'license' => [
        'name' => 'Apache 2.0',
        'url' => 'http://www.apache.org/licenses/LICENSE-2.0.html',
    ],
];
