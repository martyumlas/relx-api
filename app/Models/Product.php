<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $appends = ['image'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getImageAttribute()
    {
        return '/storage/'.$this->attributes['image'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
