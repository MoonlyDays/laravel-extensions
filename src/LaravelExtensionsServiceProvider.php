<?php

namespace MoonlyDays\LaravelExtensions;

use Illuminate\Support\ServiceProvider;
use MoonlyDays\LaravelExtensions\Extensions\FakerProvider;
use MoonlyDays\LaravelExtensions\Extensions\Pipeline;
use MoonlyDays\LaravelExtensions\Extensions\Translator;
use Faker\Generator as FakerGenerator;

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

    public function boot(): void
    {
        if (class_exists(FakerGenerator::class)) {
            $faker = app(FakerGenerator::class);
            $faker->addProvider(new FakerProvider($faker));
        }
    }
}
