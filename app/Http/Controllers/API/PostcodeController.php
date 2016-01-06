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
            return response()->json(['status' => 'failure', 'message' => trans('postcode.api.error.postcode.invalid'), 'errors' => $validator->getMessageBag()], 400);
        }

        $postcode = (int) $postcode;

        if(PostcodeValidator::isInDeliveryRange($postcode)) {
            $response = response()->json([
                'status' => 'success',
                'delivery' => true,
                'storeUrl' => localize_url('routes.shop.index'),
                'message' => trans('postcode.check.success'),
            ]);

        } else {
            $response = response()->json([
                'status' => 'success',
                'delivery' => false,
                'message' => trans('postcode.check.error.title'),
                'description' => trans('postcode.check.error.desc'),
                'storeUrl' => localize_url('routes.shop.index'),
                'confirmButtonText' => trans('postcode.browse-store'),
            ]);
        }

        return $response->withCookie(cookie()->forever('postcode', $postcode,  $path = null, $domain = null, $secure = false, $httpOnly = false));
    }
}