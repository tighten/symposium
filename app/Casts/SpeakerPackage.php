<?php

namespace App\Casts;

use Cknow\Money\Money;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class SpeakerPackage implements Arrayable, Castable
{
    public const CATEGORIES = [
        'food',
        'hotel',
        'travel',
    ];

    private $categories;

    private $currency;

    public function __construct($package)
    {
        $package = json_decode($package, true) ?? [];

        $this->categories = Arr::except($package, ['currency']);
        $this->currency = $package['currency'] ?? null;
    }

    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
                return new SpeakerPackage(
                    $value,
                );
            }

            public function set($model, $key, $value, $attributes)
            {
                return json_encode($value);
            }
        };
    }

    public function toDisplay()
    {
        if (! $this->currency) {
            return collect();
        };

        return collect($this->categories)->map(function ($item) {
            $currency = $this->currency;

            return $item > 0 ? Money::$currency($item)->formatByIntl() : null;
        });
    }

    public function toDecimal()
    {
        if (! $this->currency) {
            return collect();
        };

        return collect($this->categories)->map(function ($item) {
            $currency = $this->currency;

            return $item > 0 ? Money::$currency($item)->formatByDecimal() : null;
        });
    }

    public function toArray()
    {
        if (! $this->currency) {
            return [];
        };

        return array_merge($this->categories, ['currency' => $this->currency]);
    }

    public function count()
    {
        return count($this->categories);
    }

    public function __get($value)
    {
        if ($value === 'currency') {
            return $this->currency;
        }

        return $this->categories[$value] ?? null;
    }
}
