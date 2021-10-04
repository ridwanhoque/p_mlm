<?php

namespace App\Models;

use App\Contracts\ShouldUseStatus;
use App\Traits\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements ShouldUseStatus
{
    use OrderStatus;

    protected $fillable = [
        'shipping_address', 'district_id', 'total', 'status', 'total_commission'
    ];

    protected $casts = [
        'total' => 'float'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Order $order){
            $order->forceFill([
                'user_id' => auth()->id()
            ]);
        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function wallets()
    {
        return $this->morphMany(Wallet::class, 'walletable');
    }

    // Helpers
    public function getOrderedAtAttribute()
    {
        return $this->created_at->format('d M, Y');
    }

    public function isItOwner()
    {
        return $this->user_id === auth()->id();
    }

    public function updateStatus($status)
    {
        return $this->update([
            'status' => $status
        ]);
    }
}
