<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class SearchTest extends TestCase
{
    use WithoutMiddleware;

    public function testVodkaSearch()
    {

        $this->visit('en/search/vodka')->see('vodka');
    }
}