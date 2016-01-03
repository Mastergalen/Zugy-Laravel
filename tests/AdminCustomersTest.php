<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminCustomersTest extends TestCase
{
    use DatabaseTransactions;

    public function testViewCustomer()
    {
        $customer = factory(App\User::class)->create();

        $admin = factory(App\User::class, 'admin')->make();

        $this->actingAs($admin)->visit('admin/customer/' . $customer['id'])->see($customer['name']);
    }
}
