<?php

if ( ! function_exists('localize_url'))
{
    function localize_url($transKeyName, array $attributes = [])
    {
        return Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), $transKeyName, $attributes);
    }
}

if( ! function_exists('is_bot'))
{
    function is_bot() {
        return (isset($_SERVER['HTTP_USER_AGENT'])
            && (preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT']) || str_contains($_SERVER['HTTP_USER_AGENT'], 'Google Page Speed Insights'))
        );
    }
}