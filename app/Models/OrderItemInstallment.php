<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemInstallment extends Model
{
    protected $fillable = [
        'order_item_id', 'duration', 'name', 'payment_date', 's_cheque_no', 'installment_amount',
        'commission', 'status', 'updated_by'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
