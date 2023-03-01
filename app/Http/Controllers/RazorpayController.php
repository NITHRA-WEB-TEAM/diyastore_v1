<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Illuminate\Http\Request;

class RazorpayController extends Controller
{

    public function Payment(Request $request)
    {
//        return $request;


        $api = new Api(env('RZ_KEY_ID'), env('RZ_SECRET'));
//        $api = new Api('rzp_test_CvrmThFEnZgW1U', 'k2RzzwS6Q8tAb0nXs3SNoTym');
        $paymentDetail = $api->payment->fetch($request->payment_id)->toArray();
//        $status = Arr::get($paymentDetail, 'status');
        return $paymentDetail;
    }

    //
}
