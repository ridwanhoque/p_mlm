<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'name', 'is_it_personal'
    ];


    public function scopePersonal(Builder $builder)
    {
        return $builder->where('is_it_personal', 1);
    }


    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(UserConversation::class);
    }
}
