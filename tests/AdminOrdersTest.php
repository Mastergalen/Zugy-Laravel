<?php

class AdminOrdersTest extends TestCase
{
    protected $admin;

    public function testOrdersIndex()
    {
        $admin = factory(App\User::class, 'admin')->make();

        $this->actingAs($admin)->visit('admin/order');
    }
}