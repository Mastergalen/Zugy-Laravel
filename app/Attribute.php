<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function description() {
        return $this->hasMany('App\AttributeDescription');
    }
}
