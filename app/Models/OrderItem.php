<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'quantity', 'price', 'status', 'commission', 'orderable_id', 'orderable_type'
    ];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function packageProducts()
    {
        return $this->hasMany(OrderPackageProduct::class, 'item_id');
    }

    public function installments()
    {
        return $this->hasMany(OrderItemInstallment::class);
    }

    public function getSubtotalAttribute()
    {
        return ($this->price * $this->quantity);
    }
}
