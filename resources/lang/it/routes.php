<?php

return [
    'account' => [
        'index' => 'conto',
        'orders' => 'conto/ordini',
        'settings' => 'conto/impostazioni'
    ],
    'cart' => 'carrello',
    'checkout' => [
        'landing'      => 'cassa',
        'address'      => 'cassa/indirizzo',
        'payment'      => 'cassa/pagamento',
        'review'       => 'cassa/rivedere',
        'confirmation' => 'cassa/conferma',
        'gatewayReturn' => 'cassa/gatewayReturn',
    ],
    'order' => [
        'show' => 'ordini/{id}',
    ],
    'privacy-policy' => 'informativa-sulla-privacy',
    'product' => 'prodotto/{slug}',
    'search' => 'ricerca/{query}',
    'shop' => [
        'index' => 'negozio',
        'category' => 'negozio/categoria/{slug}',
    ],
    'terms-and-conditions' => 'termini-e-condizioni',
];