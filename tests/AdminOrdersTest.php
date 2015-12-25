<?php

class AdminOrdersTest extends TestCase
{
    protected $admin;

    public function __construct()
    {
        parent::setUp();

        $this->admin = factory(App\User::class, 'admin')->make();
    }

    public function testOrdersIndex()
    {
        $this->actingAs($this->admin)->visit('admin/order');
    }
}