<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $fillable = [
        'purchase_id', 'amount'  
    ];

    public $casts = [
        'amount' => 'float'
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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
