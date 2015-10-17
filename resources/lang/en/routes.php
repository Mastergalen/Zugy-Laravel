<?php

return [
    'cart' => 'cart',
    'checkout' => [
        'landing'      => 'checkout',
        'guest'        => 'checkout/guest',
        'address'      => 'checkout/address',
        'payment'      => 'checkout/payment',
        'review'       => 'checkout/review',
        'confirmation' => 'checkout/confirmation',
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