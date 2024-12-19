<?php

namespace MoonlyDays\LaravelPipelinesExceptTheyreCooler;

use App\Extensions\CoolerPipeline;
use Illuminate\Support\ServiceProvider;

class CoolerPipelineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('pipeline', function ($pipeline, $app) {
            return new CoolerPipeline($app);
        });
    }
}
