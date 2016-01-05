<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('integerArray', function($attribute, $value, $parameters)
        {
            foreach($value as $v) {
                if(!is_numeric($v) && !is_int((int)$v)) return false;
            }

            if(count($value) == 0) return false;

            return true;
        });

        Validator::extend('deliveryPostcode', function($attribute, $value, $parameters)
        {
            return \Zugy\Validators\PostcodeValidator::isInDeliveryRange($value);
        });

        Validator::extend('correct_password', function($attribute, $value, $parameters)
        {
            return auth()->attempt(['id' => auth()->user()->id, 'password' => $value]);
        });

        Validator::replacer('correct_password', function($message, $attribute, $rule, $parameters)
        {
            return trans('auth.form.current_password.error');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
