<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Paytm;
use Illuminate\Support\Facades\DB;
class RazorpayController extends Controller
{

    public function initiate()
    {
        return view('paytm');
    }

    public function Payment(Request $request)
    {
        $inv_prefix = $year .= "/DIYA/";
        $sql =  DB::table('pay_details')->select('inv_prefix', DB::raw("Max(inv_no) as inv_no"))
            ->where('inv_prefix', '=', $inv_prefix)
            ->first();

        $unique_number = 'POOJA_STORE-' . uniqid(0, FALSE);
        $paytype =$request->'paytype';
        $addressDetails= DB::table('address')->where('id',$request->'addressID')->select('name','address','pincode','state')->first();
        $postalID =$request->'postalID';
        $paymode =$request->'payment_id';
        $ProID =$request->'ProID';
        $inv_no = $sql->inv_no ?? 0;
        $insert_array = array(
            'mobile' => $request->mobile,
            'inv_prefix' => $inv_prefix,
            'inv_no' => $inv_no,
            'order_id' => $unique_number,
            'TXN_AMOUNT' => $amount,
            'shiping_amnt' => $ship_amnt,
            'TXN_STATUS' => 'TXN_SUCCESS',
            'TXN_DATE' => now(),
            'amount' => $amount,
            'user_id' => $regid,
            'transaction_num' => $transaction_num,
            'actual_amount' => $amount,
            'cdate' => now(),
            'cip' => $request->ip()
        );
        $lastID = DB::table('pay_details')->create($insert_array);

          $order_array = array(
              'user_id' => $request->userId,
              'pay_id' => $LastId->id,
              'login_mobile' => $request->login_mobile,
              'mobile' => $request->mobile,
              'pro_id' => $values,
              'payment_type' => $paymode,
              'name' => $addressDetails->name,
              'state' =>$addressDetails->state,
              'address' => $request->'addressID',
              'pincode' => $addressDetails->pincode,
              'email' => $addressDetails->email,
              'qty' => $qtys[$KeysId],
              'from_app' => $from_app,
              'cdate' => now(),
              'cip' => $request->ip(),
          );


        $api = new Api(env('RZ_KEY_ID'), env('RZ_SECRET'));
//        $api = new Api('rzp_test_CvrmThFEnZgW1U', 'k2RzzwS6Q8tAb0nXs3SNoTym');
        $paymentDetail = $api->payment->fetch($request->payment_id)->toArray();
        $status = Arr::get($paymentDetail, 'status');
        return $status;
    }

    public function pay(Request $request)
    {
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
