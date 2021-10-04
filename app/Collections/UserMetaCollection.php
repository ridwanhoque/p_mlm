<?php
namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class UserMetaCollection extends Collection
{
    public function meta()
    {
        return collect(array_column($this->toArray(), 'value', 'key'));
    }
}