<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function description() {
        return $this->hasMany('App\AttributeDescription');
    }

    public static function getByLanguage($language_id) {
        return Attribute::with(['description' => function ($query) use ($language_id) {
            $query->where('language_id', '=', $language_id);
        }])->get()->pluck('description');
    }
}
