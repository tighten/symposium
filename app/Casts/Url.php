<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Url implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return ($value && ! str_contains($value, 'http')) ? "https://{$value}" : $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return ($value && ! str_contains($value, 'http')) ? "https://{$value}" : $value;
    }
}
