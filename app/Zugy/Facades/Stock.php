<?php

namespace Zugy\Facades;

use Illuminate\Support\Facades\Facade;

class Stock extends Facade
{
    protected static function getFacadeAccessor() { return 'stock'; }
}