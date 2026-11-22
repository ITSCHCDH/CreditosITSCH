<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    /*
    |-------------------------------------------------------------------------- 
    | Sistema institucional de control escolar (SIT)
    |-------------------------------------------------------------------------- 
    |
    | Estas URLs solamente crean enlaces a SIT. Ningún modelo o formulario
    | de este módulo escribe en la base institucional.
    */
    'sit' => [
        'url' => rtrim((string) env('SIT_PORTAL_URL', env('SIT_URL', 'https://sit.cdhidalgo.tecnm.mx')), '/'),
        'perfil_url' => rtrim((string) env('SIT_PERFIL_URL', 'https://sit.cdhidalgo.tecnm.mx/mi-perfil'), '/'),
        'base_url' => rtrim((string) env('SIT_PORTAL_URL', env('SIT_URL', env('APP_URL', ''))), '/'),
        'alumno_url' => env('SIT_ALUMNO_URL', ''),
        'alumno_profile_url_template' => env('SIT_ALUMNO_PROFILE_URL_TEMPLATE', ''),
    ],

];
