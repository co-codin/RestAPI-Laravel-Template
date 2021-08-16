<?php

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
        'review_mail' => env('REVIEW_EMAIL'),
        'forms' => env('FORM_EMAIL'),
        'director' => env('FORM_DIRECTOR_EMAIL'),
        'exception' => env('NOTIFY_EXCEPTION_EMAIL'),
    ],

    'yandex-market' => [
        'filename' => env('YANDEX_MARKET_FILENAME', 'ymlmarket'),
    ],

    'tiu' => [
        'company_name' => env('APP_NAME')
    ],

    'google-market' => [
        'company_name' => env('APP_NAME'),
        'link' => env('APP_URL'),
        'description' => env('GOOGLE_MARKET_DESCRIPTION', 'Best store'),
    ],

    'facebook-market' => [
        'filename' => env('FACEBOOK_MARKET_FILENAME', 'facebookmarket'),
    ],
];
