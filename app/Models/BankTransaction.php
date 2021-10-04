<?php

namespace App\Models;

use App\Contracts\ShouldUseOnWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BankTransaction extends Model implements ShouldUseOnWallet
{
    protected $fillable = [
        'bank_name', 'transaction_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'user_id' => auth()->id()
            ]);
        });
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'walletable');
    }
}
