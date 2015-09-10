<?php
/**
 * User: Galen Han
 * Date: 08.09.2015
 * Time: 20:50
 */

namespace App\Services;
use App\Address;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Webpatser\Countries\Countries;

class CreateOrUpdateAddress
{
    protected $rules = [
        'name' => 'required|string|max:64',
        'line_1' => 'required|string|max:64',
        'line_2' => 'string|max:64',
        'postcode' => 'required|max:10', //TODO Validate ZIP in delivery radius
        'city' => 'required|max:32',
        'country' => 'required|size:3|exists:countries,iso_3166_3', //TODO validate is Italy
    ];

    public function delivery(array $deliveryInput, $addressId = null)
    {
        $this->rules['delivery_instructions'] = 'max:1000';
        $this->rules['phone'] = 'required'; //TODO Validate valid phone

        $validator = Validator::make($deliveryInput, $this->rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $address = new Address($deliveryInput);

        $country_id = Countries::where('iso_3166_3', '=', $deliveryInput['country'])->first()->pluck('id');

        $address->country_id = $country_id;

        if(isset($deliveryInput['default'])) {
            auth()->user()->addresses()->update(['isShippingPrimary' => false]);
            $address->isShippingPrimary = true;
        }

        if(isset($deliveryInput['billing_same'])) {
            auth()->user()->addresses()->update(['isBillingPrimary' => false]);
            $address->isBillingPrimary = true;
        }

        auth()->user()->addresses()->save($address);

        return true;
    }

    public function billing(array $billingInput, $addressId = null)
    {
        $validator = Validator::make($billingInput, $this->rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $address = auth()->user()->addresses()->create($billingInput);

        $country_id = Countries::where('iso_3166_3', '=', $billingInput['country'])->first()->pluck('id');

        $address->country_id = $country_id;

        if(isset($deliveryInput['default'])) {
            auth()->user()->addresses()->update(['isShippingPrimary' => false]);
            $address->isShippingPrimary = true;
        }

        $address->save();

        return true;
    }
}