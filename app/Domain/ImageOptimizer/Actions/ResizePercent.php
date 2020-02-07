<?php

namespace App\Domain\ImageOptimizer\Actions;

use Intervention\Image\Facades\Image;

class ResizePercent
{
    /**
     * Resize our Image by Percent
     *
     * @param Image $image
     * @param [type] $resize_percent
     * @param [type] $filepath
     * @return void
     */
    public function execute(string $filepath, $resize_percent) : void
    {
        $image = Image::make($filepath);

        $resize_height = (int) ($image->height() * ($resize_percent / 100));
        $resize_width = (int) ($image->width() * ($resize_percent / 100));

        $image->resize($resize_height, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save($filepath);
    }
}