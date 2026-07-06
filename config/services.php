<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'google_genai' => [
        'key' => env('GOOGLE_GENAI_API_KEY'),
        'model' => env('GOOGLE_GENAI_MODEL', 'gemini-2.0-flash'),
    ],

];
