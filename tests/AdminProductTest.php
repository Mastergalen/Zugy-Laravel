<?php

class AdminProductTest extends TestCase
{
    protected $admin;

    public function setUp()
    {
        parent::setUp();
        
        $this->admin = factory(App\User::class, 'admin')->make();
    }


    public function testIndexProductView()
    {
        $this->actingAs($this->admin)->visit('admin/catalogue')->see('Catalogue');
    }

    public function testAddProductView()
    {
        $this->actingAs($this->admin)->visit('admin/catalogue/create')->see('Add a product');
    }
}