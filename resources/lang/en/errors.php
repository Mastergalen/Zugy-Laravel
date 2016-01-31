<?php

return [
    'unknown' => 'An unknown error occurred. Please try again',
    'stripe.invalid_number' =>       "The card number is not a valid credit card number.",
    'stripe.invalid_expiry_month' => "The card's expiration month is invalid.",
    'stripe.invalid_expiry_year' =>  "The card's expiration year is invalid.",
    'stripe.invalid_cvc' =>          "The card's security code is invalid.",
    'stripe.incorrect_number' =>     "The card number is incorrect.",
    'stripe.expired_card' =>         "The card has expired.",
    'stripe.incorrect_cvc' =>        "The card's security code is incorrect.",
    'stripe.incorrect_zip' =>        "The card's zip code failed validation.",
    'stripe.card_declined' =>        "The card was declined.",
    'stripe.missing' =>              "There is no card on a customer that is being charged.",
    'stripe.processing_error' =>     "An error occurred while processing the card.",
    '404.message' => 'Page not found',
    '404.description' => 'We were unable to find the page you were looking for, sorry!',
    '500.message' => 'An internal error occurred',
    '500.description' => 'An error occurred, this error has been reported to us and we will fix it as soon as we can - sorry!',
];