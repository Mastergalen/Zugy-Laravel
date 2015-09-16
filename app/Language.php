<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Language extends Model
{
    static public function getLanguageId($language_code = null) {
        if($language_code == null) $language_code = LaravelLocalization::getCurrentLocale();

        return Language::where('code', '=', $language_code)->first()->pluck('id');
    }
}
