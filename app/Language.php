<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Cache;

class Language extends Model
{
    static public function getLanguageId($language_code = null) {
        if($language_code == null) $language_code = LaravelLocalization::getCurrentLocale();

        $languages = \Cache::remember('languages', 60, function() {
            return Language::all();
        });

        return $languages->where('code', $language_code)->first()->id;
    }

    public function getCodeAttribute($value) {
        return strtolower($value);
    }
}
