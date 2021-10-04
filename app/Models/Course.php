<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'duration', 'discount_percentage', 'discount_amount', 'discount_start_date', 'discount_end_date',
        'commission', 'comments', 'cash_back', 'nb', 'position', 'is_publish', 'delivery_center', 'number_of_lecture',
        'class_per_week', 'price'
    ];

    protected $with = [
        'images'
    ];

    protected $casts = [
        'discount_percentage' => 'float',
        'price' => 'float',
        'discount_amount' => 'float',
        'commission' => 'float',
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

        static::deleted(function (Course $course){
            $course->images->each->delete();
        });

        static::addGlobalScope('publish', function (Builder $builder){
            $builder->whereIsPublish(1);
        });
    }

    // Relations

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_category', 'course_id', 'category_id')
            ->withPivot('depth');
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class, 'course_id');
    }


    // Helpers

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function syncCategories(array $categories)
    {
        $syncCategories = [];

        foreach ($categories as $key => $category){
            $syncCategories[$category] = ['depth' => ($key + 1)];
        }

        $this->categories()->sync($syncCategories);
    }

    public function publish($type)
    {
        return $this->publish[$this->is_publish][$type];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function syncModules(array $modules)
    {
        $existsModules = [];

        foreach ($modules as $module){
            if(array_key_exists('id', $module)){
                /** @var CourseModule $courseModule */
                $courseModule = CourseModule::find($module['id']);

                $courseModule->update($module);
                $existsModules[] = $module['id'];
                continue;
            }

            $existsModules[] = $this->modules()->create($module)->id;
        }

        $this->modules()->whereNotIn('id', $existsModules)->delete();
    }
}
