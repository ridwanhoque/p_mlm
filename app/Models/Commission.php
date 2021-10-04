<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'amount', 'commission_from_id', 'commission_from_type',
        'user_id',
    ];

    public function commissionFrom()
    {
        return $this->morphTo('commission_from');
    }
}
