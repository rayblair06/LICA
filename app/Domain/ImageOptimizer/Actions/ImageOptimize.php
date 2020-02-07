<?php

namespace App\Domain\ImageOptimizer\Actions;

use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimize
{
    /**
     * Optimize our Image
     *
     * @param [type] $path_to_image
     * @param [type] $path_to_output
     * @return void
     */
    public function execute($filepath) : void
    {
        $image_optimizer = OptimizerChainFactory::create();

        $image_optimizer->optimize($filepath);
    }
}