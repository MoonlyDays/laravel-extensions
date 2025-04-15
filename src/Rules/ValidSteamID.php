<?php

namespace MoonlyDays\LaravelExtensions\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use InvalidArgumentException;
use xPaw\SteamID\SteamID;

class ValidSteamID implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $s = new SteamID($value);
            if ($s->isValid()) {
                return;
            }
        } catch (InvalidArgumentException) {

        }

        $fail('The :attribute field is not a valid Steam ID.');
    }
}
