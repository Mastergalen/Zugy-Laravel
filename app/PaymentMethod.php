<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'users_payment_method';

    protected $casts = [
        'payload' => 'json'
    ];

    protected $fillable = ['method', 'payload'];

    public function scopeDefault($query) {
        return $query->where('isDefault', '=', 1)->first();
    }
}
