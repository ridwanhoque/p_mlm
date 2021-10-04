<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BonusCommission extends Model
{
    protected $fillable = [
        'name', 'percentage', 'is_active', 'payable'
    ];

    protected $statues = [
        [
            'text' => 'Inactive',
            'className' => 'danger'
        ],
        [
            'text' => 'Active',
            'className' => 'success'
        ]
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (BonusCommission $commission){
            $commission->forceFill([
                'created_by' => auth()->id()
            ]);
        });

        static::updating(function (BonusCommission $commission){
            $commission->forceFill([
                'updated_by' => auth()->id()
            ]);
        });
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }

    public function status()
    {
        return $this->statues[$this->is_active];
    }
}
