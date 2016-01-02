<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Zugy\Validators\PostcodeValidator;

class PostcodeController extends Controller
{
    public function checkPostcode($postcode)
    {
        $validator = Validator::make(['postcode' => $postcode], [
            'postcode' => 'integer|digits:5'
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failure', 'message' => 'The postcode was invalid', 'errors' => $validator->getMessageBag()], 400);
        }

        $postcode = (int) $postcode;

        if(PostcodeValidator::isInDeliveryRange($postcode)) {
            return [
                'status' => 'success',
                'delivery' => true,
                'storeUrl' => localize_url('routes.shop.index'),
                'message' => 'We deliver to you!',
            ];
        } else {
            return [
                'status' => 'success',
                'delivery' => false,
                'message' => 'We currently do not deliver to your area. Sorry!',
                'description' => 'You can still browse our store, however.',
                'storeUrl' => localize_url('routes.shop.index'),
                'confirmButtonText' => "Browse the store",
            ];
        }
    }
}