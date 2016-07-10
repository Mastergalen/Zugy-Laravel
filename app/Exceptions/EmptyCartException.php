<?php

namespace App\Exceptions;


class EmptyCartException extends \Exception
{
    public function __construct($message = "Cart cannot be empty")
    {
        parent::__construct($message);
    }
}