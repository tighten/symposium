<?php

namespace App\Casts;

use Cknow\Money\Money;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

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
                    json_decode($value, true) ?? [],
                );
            }

            public function set($model, $key, $value, $attributes)
            {
                return json_encode($value->toDatabase());
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

    public function toDecimal($category)
    {
        if (! $this->currency || ! array_key_exists($category, $this->categories)) {
            return;
        };

        return with($this->categories[$category], function ($amount) {
            if (! $amount > 0) {
                return;
            }

            $currency = $this->currency;

            return Money::$currency($amount)->formatByDecimal();
        });
    }

    public function toArray()
    {
        if (! $this->currency) {
            return [];
        };

        return array_merge(['currency' => $this->currency], $this->categories);
    }

    public function count()
    {
        return count($this->categories);
    }

    public function toDatabase()
    {
        $speakerPackage = [
            'currency' => $this->currency,
        ];

        // Since users have the ability to enter punctuation or not,
        // then we want to use the appropriate parser
        foreach (SpeakerPackage::CATEGORIES as $category) {
            $itemHasPunctuation = Str::of($this->$category)->contains([',', '.']);

            $speakerPackage[$category] = Money::parse(
                $this->$category,
                $this->currency,
                ! $itemHasPunctuation,
                App::currentLocale()
            )->getAmount();
        }

        return $speakerPackage;
    }

    public function __get($value)
    {
        if ($value === 'currency') {
            return $this->currency;
        }

        return $this->categories[$value] ?? null;
    }
}
