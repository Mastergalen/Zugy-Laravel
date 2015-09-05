<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    static public function getLanguageId($language_code) {
        return Language::where('code', '=', $language_code)->first()->pluck('id');
    }
}
