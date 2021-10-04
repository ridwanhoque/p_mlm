<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCenter extends Model
{
    protected $fillable = [
        'name', 'address'
    ];
}
