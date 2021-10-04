<?php

namespace App\Models\Wallets;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;

class BkashCashIn extends Model
{
    protected $fillable = [
        'account_number', 'transaction_id'
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

    public function transactions()
    {
        return $this->morphMany(Wallet::class, 'walletable');
    }
}
