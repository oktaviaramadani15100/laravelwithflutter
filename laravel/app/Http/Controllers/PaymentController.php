<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Request $request){
        $params = array(
            'transaction_details' => array(
                'order_id'=> Str::uuid(),
               'gross_amount' => $request->price,
            ),
            'item_details' => array(
                array(
                    'price' => $request->price,
                    'quantity' => 1,
                    'name' => $request->item_name,
                )
            ),
            'customer_details' => array(
                'firts_name' => $request->customer_first_name,
                'email' => $request->customer_email,
            ),
            'enabled_payments' => array(
                'credit_card', 'bca_va', 'bni_va', 'bri_va',
            )
        );
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

        $response = json_decode($response->body(), true);
        //save to db
        $payment = new payment;
        $payment->order_id = $params['transaction_details'][ 'order_id'];
        $payment->status = 'pending';
        $payment->price = $request->price;
        $payment->customer_firts_name = $request->customer_firts_name;
        $payment->customer_email = $request->customer_email;
        $payment->item_name = $request->item_name;
        $payment->checkout_link = $response['redirect_url'];
        $payment->save();

        return response()->json($response);

    }
}
