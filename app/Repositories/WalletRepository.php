<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class WalletRepository
{
    public function presentWalletAmount()
    {
        /** @var User $user */
        $user = auth()->user();

        return Cache::remember('wallet-amount-'. $user->id, now()->addDay(), function () use($user){

            return $user->wallets()->sum('amount');
        });
    }

    public function forgetUserWallet($id = null)
    {
        $id = $id ?? auth()->id();

        return Cache::forget('wallet-amount-'. $id);
    }
}