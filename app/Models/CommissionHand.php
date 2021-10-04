<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommissionHand extends Model
{
    protected $fillable = [
        'label', 'hand_level', 'commission'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (CommissionHand $commissionHand){
            $commissionHand->forceFill([
                'created_by' => auth()->id()
            ]);
        });

        static::updating(function (CommissionHand $commissionHand){
            $commissionHand->forceFill([
                'updated_by' => auth()->id()
            ]);
        });

        static::addGlobalScope('orderBy', function (Builder $builder){
            $builder->orderBy('hand_level', 'desc');
        });
    }

    protected $casts = [
        'commission' => 'float'
    ];
}
