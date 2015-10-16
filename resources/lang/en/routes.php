<?php

return [
    'shop' => [
        'index' => 'shop',
        'category' => 'shop/category/{slug}',
    ],
    'product' => 'product/{slug}',
    'search' => 'search/{query}',
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
    ]
];