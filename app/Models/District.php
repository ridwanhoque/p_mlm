<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;

    public function isOutsideDhaka()
    {
        return (bool) ! ($this->is_outside_dhaka);
    }
}
