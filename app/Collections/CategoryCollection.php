<?php
namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class CategoryCollection extends Collection
{
    public function makeTree()
    {
        $categories = $this->groupBy('parent_id');

        $categories['root'] = $categories[''];

        unset($categories['']);

        return $categories;
    }
}