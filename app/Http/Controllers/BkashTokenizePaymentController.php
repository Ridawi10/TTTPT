<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
use Karim007\LaravelBkashTokenize\Facade\BkashRefundTokenize;

class BkashTokenizePaymentController extends Controller
{
    public function index()
    {
        return view('bkashT::bkash-payment');
    }

    public function createPayment(Request $request)
    {
        $inv = uniqid();
        $request['intent'] = 'sale';
        $request['mode'] = '0011'; // 0011 for checkout
        $request['payerReference'] = $inv;
        $request['currency'] = 'BDT';
        $request['amount'] = 10;
        $request['merchantInvoiceNumber'] = $inv;
        $request['callbackURL'] = config('bkash.callbackURL');

        $request_data_json = json_encode($request->all());

        $response = BkashPaymentTokenize::cPayment($request_data_json);

        if (isset($response['bkashURL'])) {
            return redirect()->away($response['bkashURL']);
        }

        return redirect()->back()->with('error-alert2', $response['statusMessage'] ?? 'bKash payment failed');
    }

    public function callBack(Request $request)
    {
        if ($request->status === 'success') {
            $response = BkashPaymentTokenize::executePayment($request->paymentID);

            if (!$response) {
                $response = BkashPaymentTokenize::queryPayment($request->paymentID);
            }

            if (
                isset($response['statusCode'], $response['transactionStatus']) &&
                $response['statusCode'] === '0000' &&
                $response['transactionStatus'] === 'Completed'
            ) {
                return BkashPaymentTokenize::success('Thank you for your payment', $response['trxID']);
            }

            return BkashPaymentTokenize::failure($response['statusMessage'] ?? 'Payment failed');
        }

        if ($request->status === 'cancel') {
            return BkashPaymentTokenize::cancel('Your payment is canceled');
        }

        return BkashPaymentTokenize::failure('Your transaction is failed');
    }

    public function searchTnx($trxID)
    {
        return BkashPaymentTokenize::searchTransaction($trxID);
    }

    public function refund(Request $request)
    {
        $paymentID = 'Your payment id';
        $trxID = 'your transaction no';
        $amount = 5;
        $reason = 'this is test reason';
        $sku = 'abc';

        return BkashRefundTokenize::refund($paymentID, $trxID, $amount, $reason, $sku);
    }

    public function refundStatus(Request $request)
    {
        $paymentID = 'Your payment id';
        $trxID = 'your transaction no';

        return BkashRefundTokenize::refundStatus($paymentID, $trxID);
    }
}

