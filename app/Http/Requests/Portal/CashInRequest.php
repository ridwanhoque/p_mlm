<?php

namespace App\Http\Requests\Portal;

use App\Contracts\ShouldUseOnWallet;
use App\Models\BankTransaction;
use App\Models\SSLCommerzTransaction;
use App\Models\User;
use App\Repositories\WalletRepository;
use App\Services\SSLCommerz\SSLCommerz;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Shipu\SslWPayment\Payment;

class CashInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:10',
            'transaction_id' => 'required_if:payment_method,bank',
            'bank_name' => 'required_if:payment_method,bank',
            'payment_method' => 'required|in:bank,sslcommerz'
        ];
    }

    public function cashIn()
    {
        /** @var BankTransaction|SSLCommerzTransaction $transaction */
        $transaction = null;

        DB::transaction(function () use(&$transaction){
            /** @var BankTransaction|SSLCommerzTransaction $transaction */
            $transaction = $this->{$this->payment_method.'Transaction'}();


            $transaction->transaction()->create([
                'amount' => $this->amount,
                'transaction_type' => 'in'
            ]);

            (new WalletRepository())->forgetUserWallet();
        });

        if($this->payment_method == 'sslcommerz'){

            /** @var User $user */
            $user = $this->user();

            $ssl = new SSLCommerz();

             return $ssl->initiate([
                'total_amount' => $this->amount,
                'currency' => 'BDT',
                'tran_id' => $transaction->tran_id,
                'success_url' => route('portal.payment.success', $transaction),
                'fail_url' => route('portal.payment.failed', $transaction),
                'cancel_url' => route('portal.payment.cancel', $transaction),
                'emi_option' => 0,
                'cus_name' => $user->fullName(),
                'cus_email' => $user->email,
                'cus_phone' => $user->phone_number
            ]);

        }

        return back()->withMessage('Done!');
    }

    public function bankTransaction()
    {
        return BankTransaction::create([
            'bank_name' => $this->bank_name,
            'transaction_id' => $this->transaction_id
        ]);
    }

    public function sslcommerzTransaction()
    {
        return SSLCommerzTransaction::create([
            'tran_id' => uniqid(true) . microtime(true)
        ]);
    }
}
