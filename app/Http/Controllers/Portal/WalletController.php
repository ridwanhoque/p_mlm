<?php

namespace App\Http\Controllers\Portal;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\CashInRequest;

class WalletController extends Controller
{
    public function cashInIndex()
    {
        return view('portal.wallet.cash-in');
    }

    public function cashIn(CashInRequest $request)
    {
        return $request->cashIn();
    }

    public function history(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('portal.wallet.history', [

            'histories' => $user->wallets()->withUnprocessed()->latest()->paginate()
        ]);
    }
}
