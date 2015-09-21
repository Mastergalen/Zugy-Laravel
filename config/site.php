<?php

return  [
    "name" => 'Zugy',

    'maxImageSize' => 10000000, //10MB

    /*
     *  Cart
     */
    'minimumFreeShipping' => 20, //Minimum order value in Euros for free shipping
    'shippingFee' => 3, //Cart fee
    'shippingTax' => 22,

    /*
     * Email
     */
    'email' => [
        'support' => 'support@myzugy.com',
        'logo_path' => env('APP_URL') . '/img/zugy-logo-dark.png', //Full URL to logo
    ],

    /*
     * Pushbullet
     */
    'pushbullet' => [
        'channels' => [
            'orders' => 'zugyorders',
        ],
    ],
];