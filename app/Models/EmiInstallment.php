<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmiInstallment extends Model
{
    protected $fillable = [
        'installment', 'commission', 'name'
    ];

    public function emi()
    {
        return $this->belongsTo(Emi::class);
    }
}
