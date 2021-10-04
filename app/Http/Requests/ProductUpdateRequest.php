<?php

namespace App\Http\Requests;

use App\Models\Emi;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductUpdateRequest extends FormRequest
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
            'brand_id' => 'required',
            'description' => 'required',
            'supplier_id' => 'required',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount_percentage' => 'numeric',
            'discount_amount' => 'numeric',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date',
            'position' => 'required',
            'delivery_modes' => 'required',
            'images.*' => 'required|image',
            'categories' => 'required',
            'categories.*' => 'required|exists:categories,id',
            'installment_duration' => 'required_if:emi_available,1',
            'installment_interval' => 'required_if:emi_available,1|numeric',
            'number_of_installment' => 'required_if:emi_available,1|numeric|min:1',
            'installments' => 'required_if:emi_available,1',
            'price' => 'required_if:emi_available,1|numeric',
            'installments.*.installment' => 'required|numeric',
            'installments.*.commission' => 'required|numeric',
        ];
    }

    public function update(Product $product)
    {
        $endCategory = $this->get('categories', []);

        $product->update(array_merge($this->all(), [
                'emi_available' => $this->get('emi_available'),
                'category_id' => end($endCategory)
            ])
        );

        $product->syncCategories($this->get('categories', []));

        $this->uploadImages($product);

        $product->deliveryModes()->sync(
            $this->get('delivery_modes', [])
        );

        if($this->get('emi_available')){
            $this->getPossibleEmi($product);
        }
    }

    protected function uploadImages(Product $product)
    {
        /** @var UploadedFile $image */
        foreach ($this->file('images', []) as $image){
            $product->images()->create([
                'path' => $image->store(file_path())
            ]);

            Storage::makeDirectory(file_path('thumbs'));

            Image::make($image)->resize(288, 288)
                ->save('uploads/' . file_path('thumbs/' . $image->hashName()));
        }
    }

    protected function getPossibleEmi(Product $product)
    {
        if($product->emi){

            $product->emi->update(array_merge($this->all(), [
                    'comments' => $this->get('installment_comments')
                ])
            );

            return $this->updateEmiAttributes($product->emi);
        }

        $emi = $product->emi()->create($this->all());

        return $this->updateEmiAttributes($emi);
    }

    protected function updateEmiAttributes(Emi $emi)
    {
        $emi->updateInstallments($this->get('installments', []));
    }
}
