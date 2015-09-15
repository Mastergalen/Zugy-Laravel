<?php
/**
 * User: Galen Han
 * Date: 12.09.2015
 * Time: 01:25
 */

namespace Zugy\Facades;


use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'cart'; }
}