<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zugy\Facades\PaymentGateway;

class PaymentMethod extends Model
{
    protected $table = 'users_payment_method';

    protected $casts = [
        'payload' => 'json',
    ];

    protected $fillable = ['method', 'payload'];

    /**
     * Get the default payment method
     * @param $query
     * @return mixed
     */
    public function scopeDefault($query) {
        return $query->where('isDefault', '=', 1);
    }

    public function getFormatted()
    {
        $formattedPayment = PaymentGateway::set($this)->getFormatted();

        return $formattedPayment;
    }
}
