<?php

return [

    /*
     * You can get those values in the email you should have received from Apple
     */
    'user_id' => env('EPF_USER_ID'),
    'password' => env('EPF_PASSWORD'),

    /*
     * Setting it to false will deactivate any artisan command related to EPF. 
     * Useful to not clutter your artisan CLI when you only want to use the models provided
     * by the package.
     */
    
    'include_artisan_cmd' => true,


    
];
