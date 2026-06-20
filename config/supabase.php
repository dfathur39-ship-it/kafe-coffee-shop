<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supabase Project
    |--------------------------------------------------------------------------
    |
    | Project reference ada di URL dashboard:
    | https://supabase.com/dashboard/project/[PROJECT_REF]
    |
    */

    'project_ref' => env('SUPABASE_PROJECT_REF'),

    'url' => env('SUPABASE_URL'),

    'anon_key' => env('SUPABASE_ANON_KEY'),

    'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Storage (Supabase Storage)
    |--------------------------------------------------------------------------
    */

    'storage' => [
        'bucket' => env('SUPABASE_STORAGE_BUCKET', 'menu-images'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database (PostgreSQL)
    |--------------------------------------------------------------------------
    */

    'db' => [
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT', 5432),
        'database' => env('DB_DATABASE', 'postgres'),
        'username' => env('DB_USERNAME', 'postgres'),
        'password' => env('DB_PASSWORD'),
        'sslmode' => env('DB_SSLMODE', 'require'),
    ],

];
