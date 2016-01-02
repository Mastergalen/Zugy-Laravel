<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostcodeApiTest extends TestCase
{
    private $apiEndpoint = '/api/v1/postcode';

    public function testPostcodePass()
    {
        $this->get("{$this->apiEndpoint}/check/20121")
             ->seeJson([
                 'delivery' => true,
             ]);
    }

    public function testPostcodeFail()
    {
        $this->get("{$this->apiEndpoint}/check/12345")
            ->seeJson([
                'delivery' => false,
            ]);
    }
}
