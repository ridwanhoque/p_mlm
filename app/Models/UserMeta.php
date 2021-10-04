<?php

namespace App\Models;

use App\Collections\UserMetaCollection;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $fillable = [
        'key', 'value'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function newCollection(array $models = [])
    {
        return new UserMetaCollection($models);
    }
}
