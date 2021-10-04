<?php

namespace App\Models;

use App\Contracts\ShouldUseOnWallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SSLCommerzTransaction extends Model implements  ShouldUseOnWallet
{
    public $table = 'ssl_commerz_transactions';

    protected $fillable = [
        'tran_id', 'card_issuer', 'card_brand', 'card_issuer_country', 'card_issuer_country_code'
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
