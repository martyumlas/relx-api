<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait ImageUpload
{

    private $width = 600;
    private $height = 600;

    public function upload($disk='public', $img, $directory, $size)
    {
        if($size === 'thumbnail') {
            $this->width = 100;
            $this->height = 100;
        }

        $image = Image::make($img)
        ->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
        });
         
        Storage::disk($disk)->put($directory, $image->encode());
    }

    public function deleteUpload($disk='public', $path)
    {
        Storage::disk($disk)->delete($path);
    }
    
}
