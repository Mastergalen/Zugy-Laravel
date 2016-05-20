<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'aws' => [
        'region' => env('AWS_REGION'),
        'bucket' => env('AWS_BUCKET')
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
        'public' => env('STRIPE_PUBLIC'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('APP_URL') . '/auth/login/google',
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('APP_URL') . '/auth/login/facebook',
    ],

    'rollbar' => [
        'access_token' => env('ROLLBAR_ACCESS_TOKEN'),
        'post_client_item' => env('ROLLBAR_POST_CLIENT_ITEM'),
        'level' => 'error',
    ],

    'paypal' => [
        'username'  => env('PAYPAL_USERNAME'),
        'password'  => env('PAYPAL_PASSWORD'),
        'signature' => env('PAYPAL_SIGNATURE'),
        'testMode'  => env('PAYPAL_TESTMODE') == "true",
    ],

    'pushbullet' => [
        'token' => env('PUSHBULLET_TOKEN'),
        'channels' => [
            'order' => env('PUSHBULLET_ORDER_CHANNEL'),
        ]
    ]

];
