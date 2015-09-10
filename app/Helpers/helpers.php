<?php

if ( ! function_exists('localize_url'))
{
    function localize_url($transKeyName, array $attributes = [])
    {
        return Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), $transKeyName, $attributes);
    }
}