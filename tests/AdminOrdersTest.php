<?php

class AdminOrdersTest extends TestCase
{
    protected $admin;

    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(App\User::class, 'admin')->make();
    }

    public function testOrdersIndex()
    {
        $this->actingAs($this->admin)->visit('admin/order');
    }
}