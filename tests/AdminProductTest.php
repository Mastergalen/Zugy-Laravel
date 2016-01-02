<?php

class AdminProductTest extends TestCase
{

    public function testIndexProductView()
    {
        $admin = factory(App\User::class, 'admin')->make();

        $this->actingAs($admin)->visit('admin/catalogue')->see('Catalogue');
    }

    public function testAddProductView()
    {
        $admin = factory(App\User::class, 'admin')->make();

        $this->actingAs($admin)->visit('admin/catalogue/create')->see('Add a product');
    }
}