<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'isShippingPrimary', 'isBillingPrimary', 'name', 'line_1', 'line_2', 'city', 'postcode', 'state', 'phone', 'country_id', 'delivery_instructions', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function scopeBilling($query) {
        return $query->where('isBillingPrimary', '=', 1)->first();
    }
}
