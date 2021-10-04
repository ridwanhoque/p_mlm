<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emi extends Model
{
    protected $fillable = [
        'price', 'installment_duration', 'installment_interval',
        'number_of_installment', 'comments'
    ];

    public function emiable()
    {
        return $this->morphTo();
    }

    public function installments()
    {
        return $this->hasMany(EmiInstallment::class);
    }

    public function updateInstallments(array $attributes)
    {
        $keepIds = [];

        foreach ($attributes as $attribute){
            if(array_key_exists('id', $attribute)){
                /** @var EmiInstallment $installment */
                $installment = EmiInstallment::find($attribute['id']);

                $installment->update($attribute);

                $keepIds[] = $installment->id;
                continue;
            }

            $keepIds[] = $this->installments()->create($attribute)->id;
        }

        $this->installments()->whereNotIn('id', $keepIds)->delete();
    }
}
