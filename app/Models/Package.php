<?php

namespace App\Models;

use App\Contracts\ShouldUseInCart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\{HasSlug, SlugOptions};

class Package extends Model implements ShouldUseInCart
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'sale_price', 'discount_percentage', 'discount_amount', 'discount_start_date', 'discount_end_date',
        'commission', 'a_delivery_charge_dhaka', 'a_delivery_charge_out_of_dhaka', 'delivery_time_dhaka', 'emi_available',
        'delivery_time_out_of_dhaka', 'priority', 'comments', 'cash_back', 'nb', 'position', 'publish_at', 'category_id',
        'show_on_home', 'published_by'
    ];

    protected $casts = [
        'discount_percentage' => 'float',
        'sale_price' => 'float',
        'discount_amount' => 'float',
        'commission' => 'float',
        'publish_at' => 'datetime:d F, Y h:m A',
        'show_on_home' => 'boolean'
    ];

    protected $dates = [
        'publish_at'
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

        static::deleted(function (Package $package){

            $package->images->each->delete();
        });

        static::addGlobalScope('publish', function (Builder $builder){
            $builder->whereNotNull('publish_at');
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
        $this->attributes['emi_available'] = ($value ? 1: 0);
    }

    public function setPublishAtAttribute($value)
    {
        if($this->publish_at && $value){

            return;
        }
        $this->attributes['published_by'] = auth()->id();

        if(!$this->publish_at && $value){

            $this->attributes['publish_at'] = now();
        }else{

            $this->attributes['publish_at'] = null;
        }
    }
    // Scopes

    public function scopeForHomepage(Builder $builder)
    {
        return $builder->where('show_on_home', 1);
    }

    // Relations

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'package_product', 'package_id', 'product_id');
    }

    public function deliveryModes()
    {
        return $this->belongsToMany(DeliveryMode::class, 'package_delivery_mode', 'package_id', 'delivery_mode_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'package_category', 'package_id', 'category_id')
            ->withPivot('depth');
    }

    public function emi()
    {
        return $this->morphOne(Emi::class, 'emiable');
    }

    public function firstImage()
    {
        return $this->morphOne(Image::class, 'imagable');
    }
    public function immediateCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
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

//    public function publish($type)
//    {
//        return $this->publish[$this->is_publish][$type];
//    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function price($isFormatter = true, $emiPrice = false)
    {
        $price = $this->sale_price;

        if($this->discount_start_date && $this->discount_end_date){
            if(now()->between($this->discount_start_date, $this->discount_end_date)){
                $price -= $this->discount_amount;
            }
        }

        return $isFormatter ? number_format($price, 2) : $price;
    }

    public function firstImagePath($isUseSmall = true)
    {
        return '/uploads/' . $this->firstImage->path;
    }

    public function permalink()
    {
        return '/packages/' . $this->slug;
    }

    public function deliveryPriceDhaka()
    {
        // TODO: Implement deliveryPriceDhaka() method.
    }

    public function deliveryPriceOutDhaka()
    {
        // TODO: Implement deliveryPriceOutDhaka() method.
    }

    public function commission($emiPrice = false)
    {
        return $this->commission;
    }

    public function availableEmi()
    {
        return $this->emi_available;
    }
}
