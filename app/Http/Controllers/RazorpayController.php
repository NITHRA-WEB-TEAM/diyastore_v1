<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Paytm;


class RazorpayController extends Controller
{

    public function initiate()
    {
        return view('paytm');
    }

    public function Payment(Request $request)
    {
//        return $request;


        $api = new Api(env('RZ_KEY_ID'), env('RZ_SECRET'));
//        $api = new Api('rzp_test_CvrmThFEnZgW1U', 'k2RzzwS6Q8tAb0nXs3SNoTym');
        $paymentDetail = $api->payment->fetch($request->payment_id)->toArray();
//        $status = Arr::get($paymentDetail, 'status');
        return $paymentDetail;
    }

    public function pay(Request $request)
    {
        ob_start();
        $msg = "Your order from Nithra Pooja Store has been dispatched. You will receive your product with in 5 days. Track Your Product " . $track_id . ', ' . $track_url;
        $ch = curl_init();
        $msg = urlencode($msg);
        $url = "http://api.msg91.com/api/sendhttp.php?sender=NITHRA&route=4&mobiles=" . $no . "&authkey=221068AW6ROwfK5b2782c0&country=91&campaign=pooja_store&message=" . $msg . "&DLT_TE_ID=1307160938968347916";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        ob_end_clean();

        $amount = 1; //Amount to be paid
        $userData = [
            'name' => 'Mani', // Name of user
            'mobile' => '9361205926', //Mobile number of user
            'email' => 'sudar@gmail.com', //Email of user
            'fee' => 1,
            'order_id' => "9361205926_".rand(1,1000) //Order id
        ];

//        $paytmuser = Paytm::create($userData); // creates a new database record
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => $userData['order_id'],
            'user' => 5,
            'mobile_number' => $userData['mobile'],
            'email' => $userData['email'], // your user email address
            'amount' => $amount, // amount will be paid in INR.
            'callback_url' => route('status') // callback URL
        ]);
        return $payment->receive();  // initiate a new payment
    }
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId(); // return a order id
        $transaction->getTransactionId(); // return a transaction id
        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is successfull.");

        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is failed.");

        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('initiate.payment'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); //Get Response Message If Available

        // $transaction->getOrderId(); // Get order id
    }

    //
}
