<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed image
 * @property title
 * @property type
 */
class Slide extends Model
{
    protected $fillable = [
        'title', 'type', 'link', 'image', 'button_text', 'description'
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

        static::deleting(function (Slide $slide){
            Storage::delete($slide->image);
        });
    }


    // Helpers

    public function path()
    {
        return '/uploads/' . $this->image;
    }
}
