<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Contracts\ShouldUseInCart;
use Spatie\Sluggable\{HasSlug, SlugOptions};
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsToMany};

class Product extends Model implements ShouldUseInCart
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'brand_id', 'description', 'origin', 'source', 'supplier_id', 'purchase_price', 'sale_price',
        'discount_percentage', 'discount_amount', 'discount_start_date', 'discount_end_date', 'emi_available', 'commission', 'a_delivery_charge_dhaka',
        'a_delivery_charge_out_of_dhaka', 'delivery_time_dhaka', 'delivery_time_out_of_dhaka', 'return_time', 'priority', 'comments',
        'cash_back', 'nb', 'position', 'is_publish', 'category_id'
    ];

    protected $dates = [
        'discount_start_date', 'discount_end_date'
    ];

    protected $casts = [
        'discount_percentage' => 'float',
        'sale_price' => 'float',
        'purchase_price' => 'float',
        'discount_amount' => 'float',
        'commission' => 'float',
        'discount_start_date' => 'date:Y-m-d',
        'discount_end_date' => 'date:Y-m-d',
    ];

    public $publish = [
        [
            'class' => 'danger',
            'text' => 'Un Publish'
        ],
        [
            'class' => 'primary',
            'text' => 'Publish'
        ]
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            $model->forceFill([
                'created_by' => auth()->id()
            ]);
        });

        static::updating(function (Model $model){
            $model->forceFill([
                'updated_by' => auth()->id()
            ]);
        });

        static::deleted(function (Product $product){

            $product->images->each->delete();
        });

        static::addGlobalScope('publish', function (Builder $builder){
            $builder->whereIsPublish(1);
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function setEmiAvailableAttribute($value)
    {
        $this->attributes['emi_available'] = $value ? 1 : 0;
    }
    
    
    // Relations

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function firstImage()
    {
        return $this->morphOne(Image::class, 'imagable');
    }

    public function deliveryModes()
    {
        return $this->belongsToMany(DeliveryMode::class, 'product_delivery_mode', 'product_id', 'delivery_mode_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id')
            ->withPivot('depth');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function emi()
    {
        return $this->morphOne(Emi::class, 'emiable');
    }

    public function immediateCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //

    public function related() : BelongsToMany
    {
        return Category::find($this->category_id)->products()->where('id', '<>', $this->id);
    }

    // Helpers

    public function syncCategories(array $categories)
    {
        $syncCategories = [];

        foreach ($categories as $key => $category){
            $syncCategories[$category] = ['depth' => ($key + 1)];
        }

        $this->categories()->sync($syncCategories);
    }

    public function permalink()
    {
        return '/products/' . $this->slug;
    }

    public function firstImagePath($isUseSmall = true)
    {
        if($isUseSmall){
            return $this->firstImage->thumbPath();
        }

        return $this->firstImage->path();
    }


    public function shortDescription()
    {
        return Str::limit($this->description, 400, ' [...]');
    }

    protected function firstInstallment()
    {
        return $this->emi->installments->first();
    }

    public function getHasDiscountAttribute()
    {
        if($this->discount_start_date && $this->discount_end_date){
            if(now()->between($this->discount_start_date, $this->discount_end_date)){

                return true;
            }
        }

        return false;
    }

    public function getPreviousPriceAttribute()
    {
        if($this->hasDiscount){
            return $this->sale_price;
        }

        return 0;
    }

    public function getDiscountAmountAttribute()
    {
        if($this->hasDiscount){

            return $this->discount_amount;
        }

        return 0;
    }

    public function price($isFormatter = true, $emiPrice = false)
    {
        if($emiPrice){
            return $this->firstInstallment()->installment;
        }

        $price = $this->sale_price;

        if($this->hasDiscount){
            $price -= $this->discount_amount;
        }


        return $isFormatter ? number_format($price, 2) : $price;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function deliveryPriceDhaka()
    {
        return $this->a_delivery_charge_dhaka;
    }

    public function deliveryPriceOutDhaka()
    {
        return $this->a_delivery_charge_out_of_dhaka;
    }

    public function commission($emiPrice = false)
    {
        if($emiPrice){
            return $this->firstInstallment()->commission;
        }

        return $this->commission;
    }

    public function availableEmi()
    {
        return $this->emi_available;
    }
}
