<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Basket extends Model
{
    protected $table = 'users_basket';

    protected $casts = [
        'options' => 'json'
    ];

    protected $fillable = [
        'product_id',
        'name',
        'quantity',
        'price',
        'options',
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }

    /**
     * Set the keys for a save update query.
     * This is a fix for tables with composite keys
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            //Put appropriate values for your keys here:
            ->where('user_id', '=', $this->user_id)
            ->where('product_id', '=', $this->product_id);

        return $query;
    }
}
