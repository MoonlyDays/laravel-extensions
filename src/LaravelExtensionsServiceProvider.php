<?php

namespace MoonlyDays\LaravelExtensions;

use Illuminate\Support\ServiceProvider;
use MoonlyDays\LaravelExtensions\Extensions\Pipeline;
use MoonlyDays\LaravelExtensions\Extensions\Translator;

class LaravelExtensionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->extend('pipeline', function ($pipeline, $app) {
            return new Pipeline($app);
        });

        $this->app->extend('translator', function ($translator) {
            return new Translator($translator);
        });
    }
}
