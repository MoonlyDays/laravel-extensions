<?php

namespace MoonlyDays\LaravelExtensions;

use Faker\Generator as FakerGenerator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use MoonlyDays\LaravelExtensions\Extensions\FakerProvider;
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

    public function boot(): void
    {
        if (class_exists(FakerGenerator::class)) {
            $faker = app(FakerGenerator::class);
            $faker->addProvider(new FakerProvider($faker));
        }

        Number::macro('fractionPercentage', function ($numerator, $denominator) {
            return Number::percentage($denominator == 0 ? 0 : $numerator / $denominator * 100);
        });

        Collection::macro('insertAt', function (string $key, array|Arrayable $array, int $offset) {
            $items = $array instanceof Arrayable ? $array->toArray() : $array;

            $index = array_search($key, array_keys($this->items));

            if ($index === false) {
                return $this;
            }

            $position = $index + $offset;

            $this->items = array_merge(
                array_slice($this->items, 0, $position, true),
                $items,
                array_slice($this->items, $position, null, true)
            );

            /** @var Collection $this */
            return $this;
        });

        Collection::macro('insertAfter', function (string $key, array|Arrayable $array) {
            return $this->insertAt($key, $array, 1);
        });

        Collection::macro('insertBefore', function (string $key, array|Arrayable $array) {
            return $this->insertAt($key, $array, 0);
        });
    }
}
