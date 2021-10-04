<?php

namespace App\Http\Requests;

use App\Models\Emi;
use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class PackageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'sale_price' => 'required|numeric',
            'discount_percentage' => 'numeric',
            'discount_amount' => 'numeric',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date',
            'position' => 'required',
            'delivery_modes' => 'required',
            'images.*' => 'required|image',
            'categories' => 'required',
            'categories.*' => 'required|exists:categories,id',
            'products'=> 'required',
            'products.*'=> 'required|exists:products,id',
            'installment_duration' => 'required_if:emi_available,1',
            'installment_interval' => 'required_if:emi_available,1|numeric',
            'number_of_installment' => 'required_if:emi_available,1|numeric|min:1',
            'installments' => 'required_if:emi_available,1',
            'price' => 'required_if:emi_available,1|numeric',
            'installments.*.installment' => 'required',
            'installments.*.commission' => 'required',
        ];
    }

    /**
     * @param Package $package
     */
    public function update(Package $package)
    {
        $lastCategory = $this->get('categories', []);

        $package->update(array_merge($this->all(), [
            'emi_available' => $this->emi_available,
            'publish_at' => $this->publish_at,
            'show_on_home' => $this->get('show_on_home', 0),
            'category_id' => end($lastCategory)
        ]));

        $package->syncCategories($this->get('categories', []));

        $package->products()->sync($this->get('products', []));

        $package->deliveryModes()->sync($this->get('delivery_modes', []));

        /** @var UploadedFile $image */
        foreach ($this->file('images', []) as $image){
            $package->images()->create([
                'path' => $image->store(file_path())
            ]);
        }

        if($this->get('emi_available')){
            /** @var Emi $emi */
            $emi = $package->emi;

            if(!$emi){
               $emi = $package->emi()->create(array_merge($this->all(), [
                    'comments' => $this->get('installment_comments')
                ]));
            }else{
               $emi->update(array_merge($this->all(), [
                   'comments' => $this->get('installment_comments')
               ]));
            }

            $emi->updateInstallments($this->get('installments', []));
        }

        dd($this->all());
    }
}
