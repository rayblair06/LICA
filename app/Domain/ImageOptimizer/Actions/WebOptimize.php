<?php

namespace App\Domain\ImageOptimizer\Actions;

use Intervention\Image\Facades\Image;

class WebOptimize
{
    /**
     * Web Optimize our Image
     *
     * @param Image $image
     * @param [type] $filepath
     * @return void
     */
    public function execute(string $filepath) : void
    {
        $image = Image::make($filepath);

        // If it's bigger than 1080, deduce it to that
        if ($image->height() > 1080 && $image->width() > 1920) {
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $image->save($filepath);
    }
}