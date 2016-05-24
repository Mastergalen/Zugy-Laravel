<?php

class EnvTest extends TestCase
{
    public function testFacebook()
    {
        $this->assertTrue(config('services.facebook.client_id') !== null);
        $this->assertTrue(config('services.facebook.client_secret') !== null);
    }

    public function testStripe()
    {
        $this->assertTrue(config('services.stripe.secret') !== null);
        $this->assertTrue(config('services.stripe.public') !== null);
    }

    public function testMailgun()
    {
        $this->assertTrue(config('services.mailgun.domain') !== null);
        $this->assertTrue(config('services.mailgun.secret') !== null);
    }

    public function testGoogle()
    {
        $this->assertTrue(config('services.google.client_id') !== null);
        $this->assertTrue(config('services.google.client_secret') !== null);
    }

    public function testPaypal()
    {
        if(env('APP_ENV') == 'production') {
            $this->assertFalse(config('services.paypal.testMode'));
        } else {
            $this->assertTrue(config('services.paypal.testMode'));
        }

        $this->assertTrue(config('services.paypal.username') !== null);
        $this->assertTrue(config('services.paypal.password') !== null);
        $this->assertTrue(config('services.paypal.signature') !== null);
    }

    public function testAlgolia()
    {
        $this->assertTrue(env('ALGOLIA_ID') !== null);
        $this->assertTrue(env('ALGOLIA_SEARCH_KEY') !== null);
        $this->assertTrue(env('ALGOLIA_KEY') !== null);
    }

    public function testRollbar()
    {
        $this->assertNotNull(config('services.rollbar.access_token'));
        $this->assertNotNull(config('services.rollbar.post_client_item'));
    }

    public function testAWS()
    {
        $this->assertNotNull(config('filesystems.default'));

        if(env('FILE_DISC') == 's3') {
            $this->assertNotNull(config('services.aws.region'));
            $this->assertNotNull(config('services.aws.bucket'));
            $this->assertNotNull(env('AWS_KEY') !== null);
            $this->assertNotNull(env('AWS_SECRET') !== null);
        }
    }
}
