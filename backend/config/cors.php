<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Controls which origins can call the Laravel API from a browser.
    | In production, FRONTEND_URL should be set to the Netlify domain.
    | e.g. FRONTEND_URL=https://qrmenu.netlify.app
    |
    | We use token-based Sanctum auth (Bearer tokens), so supports_credentials
    | is false — no cookie sharing is needed across domains.
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Lock to Netlify domain in production; wildcard only for local dev
    'allowed_origins' => [env('FRONTEND_URL', '*')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 86400, // Cache CORS preflight for 24 hours

    'supports_credentials' => false,

];

