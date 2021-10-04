<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PromotionalDesignation extends Model
{
    protected $fillable  = [
        'name', 'stage', 'required_designation', 'required_designation_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (PromotionalDesignation $designation){
            $designation->forceFill([
                'created_by' => auth()->id()
            ]);
        });

        static::updating(function (PromotionalDesignation $designation){
            $designation->forceFill([
                'updated_by' => auth()->id()
            ]);
        });

        static::addGlobalScope('orderBy', function (Builder $builder){
            $builder->orderBy('promotional_designations.stage');
        });
    }

    public function requiredDesignation()
    {
        return $this->belongsTo(PromotionalDesignation::class, 'required_designation_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'designation_id');
    }

    public function scopeDefault(Builder $builder)
    {
        return $builder->whereNull('required_designation_id');
    }
}
