<?php

return [
    'shop' => [
        'index' => 'negozio',
        'category' => 'negozio/categoria/{slug}',
    ],

    'product' => 'prodotto/{slug}',
    'cart' => 'carrello',
    'checkout' => [
        'landing'      => 'cassa',
        'guest'        => 'cassa/ospite',
        'address'      => 'cassa/indirizzo',
        'payment'      => 'cassa/pagamento',
        'review'       => 'cassa/rivedere',
        'confirmation' => 'cassa/conferma',
    ],
    'order' => [
        'show' => 'ordine/{id}',
    ]
];