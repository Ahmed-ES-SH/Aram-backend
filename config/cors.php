<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Adjust these settings to secure your API when communicating with your
    | Next.js frontend. Only trusted origins should be allowed.
    |
    */

    'paths' => [
        'api/*',          // Allow only API routes
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://aram-gulf.com',
        'https://www.aram-gulf.com',
      	'http://localhost:3000'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'Origin',
    ],

    'exposed_headers' => [],

    'max_age' => 86400, // Cache CORS preflight for 1 day

    'supports_credentials' => true,
];
