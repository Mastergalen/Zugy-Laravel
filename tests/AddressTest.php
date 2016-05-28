<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressTest extends TestCase
{
    use DatabaseTransactions;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create();
        $this->actingAs($this->user);

        //Add item to cart to bypass checkout middleware, which requires a non-empty cart
        $product = factory(App\Product::class)->create();
        $product->translations()->save(factory(App\ProductTranslation::class)->make());

        $this->json('POST', 'api/v1/cart', [
            'id' => $product->id,
            'qty' => 1, //Qty 1
        ])->seeJson(['status' => 'success']);
    }

    /**
     * Test adding a simple address
     */
    public function testCreateAddress()
    {
        $service = new App\Services\CreateOrUpdateAddress();

        $address = factory(App\Address::class)->make([
            'country' => 'ITA'
        ]);

        $service->delivery($address->toArray());

        $database = $address->toArray();
        unset($database['country']);

        $this->seeInDatabase('addresses', $database);
    }

    /**
     * Test trying to add a delivery outside delivery area
     */
    public function testCreateAddressOutsideDeliveryArea()
    {
        $service = new App\Services\CreateOrUpdateAddress();

        $address = factory(App\Address::class)->make([
            'country' => 'ITA',
            'postcode' => 12345, //Outside delivery area
        ]);

        $service->delivery($address->toArray());

        $database = $address->toArray();
        unset($database['country']);

        $this->dontSeeInDatabase('addresses', $database);
    }

    /**
     * Test user filling out address form with a billing address that is different from the delivery address
     */
    public function testCreateDeliveryAddressWithDifferentBillingAddress() {
        $this->visit('en/checkout/address')->see('Delivery Address');

        $deliveryAddress = factory(App\Address::class)->make([
            'country' => 'ITA'
        ]);

        $billingAddress = factory(App\Address::class)->make([
            'country' => 'ITA'
        ]);

        $this->type($deliveryAddress->name, 'delivery[name]')
            ->type($deliveryAddress->line_1, 'delivery[line_1]')
            ->type($deliveryAddress->postcode, 'delivery[postcode]')
            ->type($deliveryAddress->city, 'delivery[city]')
            ->type($deliveryAddress->delivery_instructions, 'delivery[delivery_instructions]')
            ->type($deliveryAddress->phone, 'delivery[phone]')
            
            ->uncheck('delivery[billing_same]')

            ->type($billingAddress->name, 'billing[name]')
            ->type($billingAddress->line_1, 'billing[line_1]')
            ->type($billingAddress->postcode, 'billing[postcode]')
            ->type($billingAddress->city, 'billing[city]')
            
            ->press('Proceed')
        ;

        \Log::debug($deliveryAddress);
        \Log::debug($billingAddress);

        $databaseDeliveryAddress = $deliveryAddress->toArray();
        unset($databaseDeliveryAddress['country']);
        $databaseDeliveryAddress['isShippingPrimary'] = 1;
        $databaseDeliveryAddress['isBillingPrimary'] = 0;

        $databaseBillingAddress = $billingAddress->toArray();
        unset($databaseBillingAddress['country']);
        unset($databaseBillingAddress['delivery_instructions']);
        unset($databaseBillingAddress['phone']);
        $databaseBillingAddress['isShippingPrimary'] = 0;
        $databaseBillingAddress['isBillingPrimary'] = 1;

        $this->seeInDatabase('addresses', $databaseDeliveryAddress);
        $this->seeInDatabase('addresses', $databaseBillingAddress);
    }
}
