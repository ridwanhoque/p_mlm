<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name', 'phone_number', 'address'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'created_by' => auth()->id()
            ]);
        });

        static::updating(function (Model $model){
            $model->forceFill([
                'updated_by' => auth()->id()
            ]);
        });
    }
}
