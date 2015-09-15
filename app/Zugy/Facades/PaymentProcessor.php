<?php
/**
 * User: Galen Han
 * Date: 13.09.2015
 * Time: 16:32
 */

namespace Zugy\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentProcessor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'paymentProcessor'; }
}