<?php

namespace App\Models;

use App\Collections\OptionCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
//    protected $primaryKey = 'option_key';

    public $timestamps = false;

    protected $fillable = [
        'option_key', 'option_value'
    ];

    public function newCollection(array $models = [])
    {
        return new OptionCollection($models);
    }

    public function scopeCommission(Builder $builder)
    {
        return $builder->where('option_key', 'general_commission');
    }
}
