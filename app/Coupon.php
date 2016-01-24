<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $dates = ['starts', 'expires'];

    public function getDescriptionAttribute()
    {
        if($this->attributes['percentageDiscount'] != null) {
            return trans('coupon.percentageDiscountDescription', ['percentage' => $this->attributes['percentageDiscount']]);
        } elseif($this->attributes['flatDiscount'] != null) {
            return trans('coupon.flatDiscountDescription', ['amount' => $this->attributes['flatDiscount']]);
        }

        throw new \RuntimeException();
    }
}