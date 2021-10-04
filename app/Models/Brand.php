<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $fillable = [
        'name', 'logo'
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

        static::deleted(function ($brand){
            Storage::delete($brand->logo);
        });
    }


    public function logo()
    {
        return '/uploads/' . $this->logo;
    }
}
