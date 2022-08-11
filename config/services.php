<?php

use App\Helpers\MailHelper;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'auth' => [
        'url' => env('AUTH_URL'),
    ],

    'content' => [
        'domain' => env('CONTENT_API_URL', 'https://content.api.medeq.ru'),
    ],

    'roistat' => [
        'enabled' => env('ROISTAT', false),
    ],

    'crm' => [
        'domain' => env('CRM_API_URL'),
        'token' => env('CRM_TOKEN'),
    ],

    'yandex-metrika' => [
        'enabled' => env('YANDEX_METRIKA', false),
        'id' => env('YANDEX_METRIKA_ID')
    ],

    'mails' => [
        'review_mail' => MailHelper::emailsToArray(env('REVIEW_EMAIL')),
        'forms' => MailHelper::emailsToArray(env('FORM_EMAIL')),
        'director' => MailHelper::emailsToArray(env('FORM_DIRECTOR_EMAIL')),
        'exception' => MailHelper::emailsToArray(env('NOTIFY_EXCEPTION_EMAIL')),
    ],

    'dellin' => [
        'token' => env('DL_TOKEN'),
        'terminal_url' => env('DL_TERMINAL_URL', 'https://api.dellin.ru/v3/public/terminals.json'),
        'place_url' => env('DL_PLACE_URL', 'https://api.dellin.ru/v1/public/places.json'),
    ],

    'google-api' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'refresh_token' => env('GOOGLE_CLIENT_REFRESH_TOKEN'),
        'places' => env('GOOGLE_PLACES_API_KEY'),
        'drive' => [
            'files' => [
                'sold-products' => env('GOOGLE_SHEETS_SOLD_PRODUCTS_FILE_ID')
            ]
        ],
    ],

    'sypex' => [
        'url' => env('SYPEX_URL'),
    ],
];
