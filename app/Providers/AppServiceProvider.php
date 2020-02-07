<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Filesystem;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use App\Domain\ImageOptimizer\Interfaces\ImageOptimizerContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bind our Filesystem to this Storage
        $this->app
            ->bind(Filesystem::class, function () {
                return Storage::disk('public');
            });
    }
}
