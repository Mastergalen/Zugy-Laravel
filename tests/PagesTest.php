<?php

class PagesTest extends TestCase
{
    public function testHomepage()
    {
        $this->visit('/');
    }

    public function testCart()
    {
        $this->visit('en/cart')->see('Shopping Cart');
    }

    public function testPrivacyPolicy()
    {
        $this->visit('en/privacy-policy')->see('Privacy Policy');
    }

    public function testTermsConditions()
    {
        $this->visit('en/terms-and-conditions')->see('Terms and Conditions');
    }
}