<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Typeform API Key
    |--------------------------------------------------------------------------
    |
    | Personal access token generated at https://admin.typeform.com/account#/section/tokens
    | Sent as a Bearer token on every request to the Typeform API.
    |
    */
    'api_key' => env('TYPEFORM_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Typeform API Base URL
    |--------------------------------------------------------------------------
    */
    'base_url' => env('TYPEFORM_BASE_URL', 'https://api.typeform.com'),

];
