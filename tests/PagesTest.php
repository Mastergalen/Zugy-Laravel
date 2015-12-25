<?php

class PagesTest extends TestCase
{

    public function testHomepage()
    {
        $this->visit('/');
    }

    public function testCart()
    {
        $this->visit('cart')->see('Shopping Cart');
    }

    public function testPrivacyPolicy()
    {
        $this->visit('privacy-policy')->see('Privacy Policy');
    }

    public function testTermsConditions()
    {
        $this->visit('terms-and-conditions')->see('Terms and Conditions');
    }
}