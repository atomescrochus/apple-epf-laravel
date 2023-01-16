<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Apple's Enterprise Partner Feed (EPF) credentials
    |--------------------------------------------------------------------------
    |
    | You can get those values in the email you should have received from Apple
    | when joining the performance partner program.
    |
    */

    'user_id'  => env('EPF_USER_ID'),
    'password' => env('EPF_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Database connection
    |--------------------------------------------------------------------------
    |
    | Which database connection to use to import. Defaults to 'apple-epf'.
    |
    */

    'database_connection' => env('EPF_DATABASE_CONNECTION', 'apple-epf'),

    /*
    |--------------------------------------------------------------------------
    | Artisan commands
    |--------------------------------------------------------------------------
    |
    | Setting it to false will deactivate any artisan command related to EPF. 
    | Useful to not clutter your artisan CLI when you only want to use the models provided
    | by the package.
    |
    */
    
    'include_artisan_cmd' => true,

    /*
    |--------------------------------------------------------------------------
    | Storage folders
    |--------------------------------------------------------------------------
    |
    | Folders used when downloading, extracting and processing EPFs.
    | This package will use the app/local filesystem.
    |
    */

    'storage_folder'    => 'epf-imports',
    'archive_folder'    => 'archives',
    'extraction_folder' => 'files',
    
];
