<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path', 'type'
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function (Image $image){
            Storage::delete($image->path);
            if(!is_dir(public_path($image->thumbPath()))){
                Storage::delete(
                    ltrim($image->thumbPath(), '/uploads/')
                );
            }
        });
    }

    public function imagable()
    {
        return $this->morphTo();
    }

    public function path()
    {
        return '/uploads/' . $this->path;
    }

    public function thumbPath()
    {
        return '/uploads/' . dirname($this->path) . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . basename($this->path);
    }
}
