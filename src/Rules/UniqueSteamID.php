<?php

namespace MoonlyDays\LaravelExtensions\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use xPaw\SteamID\SteamID;

class UniqueSteamID implements ValidationRule
{
    public function __construct(
        protected string $table,
        protected ?string $column = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->column ??= $attribute;
        Validator::validate([$attribute => $value], [$attribute => new ValidSteamID]);

        $s = new SteamID($value);
        $value = $s->ConvertToUInt64();

        if (Validator::make(
            [$attribute => $value],
            [$attribute => 'unique:'.$this->table.','.$this->column]
        )->fails()) {
            $fail('The :attribute field is already in use.');
        }
    }
}
