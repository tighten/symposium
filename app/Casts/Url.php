<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Url implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return ($value && ! str_contains($value, 'http')) ? "https://{$value}" : $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return ($value && ! str_contains($value, 'http')) ? "https://{$value}" : $value;
    }
}
