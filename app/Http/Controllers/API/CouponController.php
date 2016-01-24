<?php

namespace App\Http\Controllers\Api;

use App\Coupon;
use App\Exceptions\Coupons\CouponExpiredException;
use App\Exceptions\Coupons\CouponNotStartedException;
use App\Exceptions\Coupons\CouponOrderMinimumException;
use App\Exceptions\Coupons\CouponUsedException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zugy\Facades\Checkout;

class CouponController extends Controller
{
    /**
     * Applies a coupon code to the current
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apply(Request $request) {
        $code = "";
        if($request->has('coupon')) {
            $code = trim($request->input('coupon'));
        }

        $coupon = Coupon::where('code', '=', $code)->first();

        if($coupon == null) {
            return response()->json(['status' => 'error', 'message' => trans('coupon.404')], 400);
        }

        try{
            Checkout::setCoupon($coupon);
        } catch(CouponUsedException $e) {
            return response()->json(['status' => 'error', 'message' => trans('coupon.claimed')], 400);
        } catch(CouponExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => trans('coupon.expired', ['date' => $coupon->expires->toFormattedDateString()])], 400);
        } catch(CouponNotStartedException $e) {
            return response()->json(['status' => 'error', 'message' => trans('coupon.notActive', ['date' => $coupon->starts])], 400);
        } catch(CouponOrderMinimumException $e) {
            return response()->json(['status' => 'error', 'message' => trans('coupon.minimum', ['min' => $coupon->minimumTotal])], 400);
        }

        return response()->json(['status' => 'success']);
    }
}