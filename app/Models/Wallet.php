<?php

namespace App\Models;

use App\Models\Wallets\BkashCashIn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * @package App\Models
 */

class Wallet extends Model
{
    protected $fillable = [
        'amount', 'is_processed', 'transaction_type'
    ];

    protected $walletTypes = [
        BkashCashIn::class => 'Bkash Cash In',
        Order::class => 'Order',
        SSLCommerzTransaction::class => 'SSL Commerz',
        BankTransaction::class => 'Bank'
    ];

    protected $processStatus = [
        [
            'text' => 'Pending', // 0
            'class' => 'warning'
        ],
        [
            'text' => 'Success', // 1
            'class' => 'success'
        ],
        [
            'text' => 'Failed', // 2
            'class' => 'danger'
        ],
        [
            'text' => 'Canceled', // 3
            'class' => 'danger',
        ],
        [
            'text' => 'Invalid', // 4
            'class' => 'danger'
        ]
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'user_id' => auth()->id()
            ]);
        });

        static::addGlobalScope('processed', function ($query){
             $query->where('is_processed', 1);
        });
    }
    // Relations

    public function walletable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithUnprocessed(Builder $builder)
    {
        return $builder->withoutGlobalScope('processed');
    }

    public function scopeOnlyTransactions(Builder $builder)
    {
        return $builder->whereIn('walletable_type', [
            BkashCashIn::class
        ]);
    }

    public function transactionFrom()
    {
        return $this->walletTypes[$this->walletable_type];
    }

    public function amount()
    {
        return '৳'.number_format($this->amount, 2);
    }

    public function processStatus($type = 'text')
    {
        return $this->processStatus[$this->is_processed][$type];
    }
}
