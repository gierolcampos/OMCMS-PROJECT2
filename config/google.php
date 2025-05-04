<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Google API services.
    | These credentials will be used to authenticate requests to
    | the Google API services that are integrated with the application.
    |
    */

    'client_id' => env('GOOGLE_CLIENT_ID', ''),
    'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
    'redirect_uri' => env('GOOGLE_REDIRECT_URI', ''),
    
    'scopes' => [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
        'https://www.googleapis.com/auth/documents',
    ],
    
    'access_type' => 'offline',
    'approval_prompt' => 'force',
    
    'application_name' => env('GOOGLE_APPLICATION_NAME', 'ICS Letter System'),
];
