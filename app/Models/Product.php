<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $appends = ['image', 'image_url'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getImageAttribute()
    {
        return Storage::url($this->attributes['image']);
    }

    public function getImageUrlAttribute()
    {
        return $this->attributes['image'];
    }

    public function getThumbnailAttribute()
    {
        return Storage::url($this->attributes['thumbnail']);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->attributes['thumbnail'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
