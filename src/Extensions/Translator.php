<?php

namespace MoonlyDays\LaravelExtensions\Extensions;

use Illuminate\Translation\Translator as BaseTranslator;
use Stringable;

class Translator extends BaseTranslator
{
    public function __construct(BaseTranslator $base)
    {
        parent::__construct(
            $base->loader,
            $base->locale
        );
    }

    public function get($key, array $replace = [], $locale = null, $fallback = true): array|string|null
    {
        if ($key instanceof Stringable) {
            $key = (string) $key;
        }

        return parent::get($key, $replace, $locale, $fallback);
    }
}
