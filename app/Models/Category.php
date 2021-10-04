<?php

namespace App\Models;

use App\Collections\CategoryCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @method static featured()
 */
class Category extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'parent_id', 'is_featured', 'image', 'show_on_home'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'show_on_home' => 'boolean'
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

        static::created(function (Category $category){
            $depth = 1;

            $callback = function (Category $newCategory, Category $parentCategory) use(&$callback, &$depth){

                $newCategory->parents()->attach([
                    $parentCategory->id => ['depth' => $depth]
                ]);

                $depth++;

                if($parentCategory->parent_id){
                    $callback($newCategory, $parentCategory->parent);
                }
            };

            if($category->parent_id){

                $callback($category, $category->parent);
            }
        });

        static::deleted(function (Category $category){
            if(is_null($category->image)){
                return;
            }
            Storage::delete($category->image);
        });
    }

    public function parents()
    {
        return $this->belongsToMany(Category::class, 'category_trees', 'category_id', 'parent_id')
            ->withPivot('depth');
    }

    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_trees', 'parent_id', 'category_id')
            ->withPivot('depth');
    }

    public function menuChildrens()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function immediateChildren()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_category', 'category_id', 'package_id');
    }

    // Scopes

    public function scopeFeatured(Builder $builder)
    {
        return $builder->where('is_featured', 1);
    }

    public function scopeRoot(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function scopeShowOnHome(Builder $builder)
    {
        return $builder->where('show_on_home', 1);
    }
    // Helpers

    public function image()
    {
        return '/uploads/' . $this->image;
    }

    public function isFeatured()
    {
        return $this->is_featured == 1;
    }

    public function permalink()
    {
        return '/categories/' . $this->slug;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }
}
