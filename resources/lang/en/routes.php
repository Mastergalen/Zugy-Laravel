<?php

return [
    'account' => [
        'index' => 'your-account',
        'orders' => 'your-account/orders',
        'settings' => 'your-account/settings',
    ],
    'cart' => 'cart',
    'checkout' => [
        'landing'       => 'checkout',
        'address'       => 'checkout/address',
        'payment'       => 'checkout/payment',
        'review'        => 'checkout/review',
        'confirmation'  => 'checkout/confirmation',
        'gatewayReturn' => 'checkout/gatewayReturn',
    ],
    'order' => [
        'show' => 'order/{id}',
    ],
    'privacy-policy' => 'privacy-policy',
    'product' => 'product/{slug}',
    'search' => 'search/{query}',
    'shop' => [
        'index' => 'shop',
        'category' => 'shop/category/{slug}',
    ],
    'terms-and-conditions' => 'terms-and-conditions',
];