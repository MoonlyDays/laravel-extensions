<?php

namespace MoonlyDays\LaravelExtensions;

use Illuminate\Support\ServiceProvider;
use MoonlyDays\LaravelExtensions\Extensions\Pipeline;

class LaravelExtensionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('pipeline', function ($pipeline, $app) {
            return new Pipeline($app);
        });
    }
}
