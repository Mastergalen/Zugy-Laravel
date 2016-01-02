<?php

namespace Zugy\Validators;

class PostcodeValidator
{
    static public function isInDeliveryRange($postcode) {
        return ($postcode >= 20121 && $postcode <= 20162);
    }
}