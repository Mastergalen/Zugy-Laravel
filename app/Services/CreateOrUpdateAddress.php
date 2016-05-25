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
    protected $defaultRules = [
        'name' => 'required|string|max:64',
        'line_1' => 'required|string|max:64',
        'line_2' => 'string|max:64',
        'postcode' => 'required|max:5|deliveryPostcode',
        'city' => 'required|max:32',
        'country' => 'required|size:3|exists:countries,iso_3166_3', //TODO validate is Italy
    ];

    public function delivery(array $deliveryInput, Address $address = null)
    {
        $deliveryRules = $this->defaultRules;
        $deliveryRules['delivery_instructions'] = 'max:1000';
        $deliveryRules['phone'] = 'required'; //TODO Validate valid phone

        $validator = Validator::make($deliveryInput, $deliveryRules);

        if($validator->fails()) {
            return $validator;
        }

        if($address == null) {
            $address = new Address($deliveryInput);
        } else {
            $address->fill($deliveryInput);
        }

        $address->country_id = Countries::where('iso_3166_3', '=', $deliveryInput['country'])->first()->id;

        if(isset($deliveryInput['default'])) {
            auth()->user()->addresses()->update(['isShippingPrimary' => false]);
            $address->isShippingPrimary = true;
        }

        if(isset($deliveryInput['billing_same'])) {
            auth()->user()->addresses()->update(['isBillingPrimary' => false]);
            $address->isBillingPrimary = true;
        }

        auth()->user()->addresses()->save($address);

        return $address;
    }

    public function billing(array $billingInput, Address $address = null)
    {
        $billingRules = $this->defaultRules;
        $billingRules['postcode'] = 'required|max:5';

        $validator = Validator::make($billingInput, $billingRules);

        if($validator->fails()) {
            return $validator;
        }

        if($address == null) {
            $address = new Address($billingInput);
        } else {
            $address->fill($billingInput);
        }

        $address->country_id = Countries::where('iso_3166_3', '=', $billingInput['country'])->first()->id;

        if(isset($billingInput['default'])) {
            auth()->user()->addresses()->update(['isBillingPrimary' => false]);
            $address->isBillingPrimary = true;
        }

        auth()->user()->addresses()->save($address);

        return $address;
    }
}