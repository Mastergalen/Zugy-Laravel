<?php

namespace Zugy\ActivityLogParser;

use Illuminate\Support\ServiceProvider;

class ActivityLogParserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('activityLogParser', function()
        {
            return new ActivityLogParser();
        });
    }
}