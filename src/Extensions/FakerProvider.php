<?php

namespace MoonlyDays\LaravelExtensions\Extensions;

use Faker\Provider\Base;
use xPaw\SteamID\SteamID;

class FakerProvider extends Base
{
    /**
     * Generates a random SteamID
     */
    public function steamId(): string
    {
        $s = new SteamID;
        $s->SetAccountID(rand());
        $s->SetAccountUniverse(1);
        $s->SetAccountType(1);
        $s->SetAccountInstance(1);

        return $s->ConvertToUInt64();
    }
}