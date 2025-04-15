<?php

namespace MoonlyDays\LaravelExtensions\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use xPaw\SteamID\SteamID as xPawSteamID;

class SteamID implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $s = new xPawSteamID($value);

        return $s->ConvertToUInt64();
    }
}
