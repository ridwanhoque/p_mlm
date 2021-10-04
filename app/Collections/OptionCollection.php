<?php
namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class OptionCollection extends Collection
{
    public function makeOption()
    {
        return $this->keyBy->option_key;
    }

    public function getOption($key, $default = null)
    {
        if($this->has($key)){
            return $this->get($key)['option_value'];
        }
        return $default;
    }

}
