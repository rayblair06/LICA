<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Domain\ImageOptimizer\Actions\WebOptimize;
use App\Domain\ImageOptimizer\Actions\ImageOptimize;
use App\Domain\ImageOptimizer\Actions\ResizePercent;

class ImageController extends Controller
{
    /**
     * Our Filesystem
     *
     * @var [type]
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function optimize(Request $request)
    {
        // Make our folder if it doesn't exist
        if (!file_exists($this->filesystem->path('images'))) {
            mkdir($this->filesystem->path('images'), 0755);
        }

        $image = (object) [
            'filename' => Str::random(40) . ".{$request->file('image')->extension()}"
        ];
        $image->filepath = $this->filesystem->path('images/' . $image->filename);

        Image::make($request->file('image'))->save($image->filepath);

        if ($request->input('resize-percent', false)) {
            app(ResizePercent::class)->execute($image->filepath, $request->input('resize-percent'));
        }

        if ($request->input('web-optimize', false)) { 
            app(WebOptimize::class)->execute($image->filepath);
        }

        if ($request->input('thumbnails', false)) {
            // Create a selection of thumbnails for us to use
            // TODO:
        }

        // Optimize Image
        app(ImageOptimize::class)->execute($image->filepath);

        $response = [
            'filename' => $this->filesystem->url('images/' . $image->filename),
            'original_size' => filesize($request->file('image')->path()),
            'optimized_size' => $this->filesystem->size('images/' . $image->filename),
            'percent_optimized' => $this->calculatePercentageSaved(
                filesize($request->file('image')->path()),
                $this->filesystem->size('images/' . $image->filename)
            ),
        ];

        return response(json_encode($response, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Calculate the Percentage Saved from two values given
     *
     * @param int $first_value
     * @param int $second_value
     * @return integer
     */
    private function calculatePercentageSaved(int $first_value, int $second_value) : int
    {
        return (int) ($first_value - $second_value) / $second_value * 100;
    }
}
