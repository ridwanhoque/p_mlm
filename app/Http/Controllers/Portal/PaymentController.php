<?php

namespace App\Http\Controllers\Portal;

use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use App\Models\SSLCommerzTransaction;
use App\Services\SSLCommerz\SSLCommerz;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function success(SSLCommerzTransaction $order, Request $request, WalletRepository $repository)
    {
        $order->load(['transaction' => function($query){
            $query->withoutGlobalScope('processed');
        }]);

        /** @var Wallet $amount */
        $amount  = $order->transaction;

        $ssl = new SSLCommerz();

        if(!$amount->is_processed && $ssl->ipnHashVerify($request)){
            $amount->update([
                'is_processed' => 1
            ]);

            $order->update(
                $request->only('card_issuer', 'card_brand', 'card_issuer_country', 'card_issuer_country_code')
            );

            $repository->forgetUserWallet();
        }

        return view('portal.wallet.payment.success');
    }

    public function cancel(SSLCommerzTransaction $order, Request $request)
    {
        $order->load(['transaction' => function($query){
            $query->withoutGlobalScope('processed');
        }]);
        /** @var Wallet $amount */
        $amount  = $order->transaction;
        $ssl = new SSLCommerz();

        if($order->is_processed != 3 && $ssl->ipnHashVerify($request)){
            $amount->update([
                'is_processed' => 3
            ]);
        }

        return view('portal.wallet.payment.cancel');
    }

    public function failed(SSLCommerzTransaction $order, Request $request)
    {
        $order->load(['transaction' => function($query){
            $query->withoutGlobalScope('processed');
        }]);
        /** @var Wallet $amount */
        $amount  = $order->transaction;
        $ssl = new SSLCommerz();

        if($order->is_processed != 2 && $ssl->ipnHashVerify($request)){
            $amount->update([
                'is_processed' => 2
            ]);
        }

        return view('portal.wallet.payment.failed');
    }
}
