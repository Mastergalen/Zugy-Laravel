<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class SearchTest extends TestCase
{
    use WithoutMiddleware;

    public function createApplication()
    {
        if(env('APP_ENV') == "testing") {
            putenv('APP_ENV=local');
        }

        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function testVodkaSearch()
    {

        $this->visit('search/vodka')->see('vodka');
    }
}