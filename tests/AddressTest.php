<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateAddress()
    {
        $service = new App\Services\CreateOrUpdateAddress();

        $user = factory(App\User::class)->create();

        $address = factory(App\Address::class)->make([
            'country' => 'ITA'
        ]);

        $this->actingAs($user);

        $service->delivery($address->toArray());

        $database = $address->toArray();
        unset($database['country']);

        $this->seeInDatabase('addresses', $database);
    }

    public function testNoDeliveryCreateAddress()
    {
        $service = new App\Services\CreateOrUpdateAddress();

        $user = factory(App\User::class)->create();

        $address = factory(App\Address::class)->make([
            'country' => 'ITA',
            'postcode' => 12345, //Outside delivery area
        ]);

        $this->actingAs($user);

        $service->delivery($address->toArray());
    }
}
