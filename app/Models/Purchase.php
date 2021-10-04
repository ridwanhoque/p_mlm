<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Purchase extends Model
{
    protected $fillable = [
        'total', 'supplier_id'
    ];

    protected $casts = [
        'total' => 'float'
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

    public function products()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    public function payments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function payment()
    {
        return $this->hasOne(PurchasePayment::class)
            ->selectRaw('sum(amount) as amount, purchase_id')
            ->groupBy('purchase_id');
    }

    // Helpers

    public function makePayment($amount)
    {
        if(!$amount){
            return;
        }

        return $this->payments()->create([
            'amount' => $amount
        ]);
    }

    public function paid()
    {
        return Arr::get($this->payment, 'amount', 0);
    }

    public function due()
    {
        return ($this->total - $this->paid());
    }
}
