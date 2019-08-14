<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Accept', 'Content-Type', 'Authorization'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'exposedHeaders' => []
];
