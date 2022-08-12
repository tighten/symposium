<?php

namespace App\Services;

use Cknow\Money\Money;
use Symfony\Component\Intl\Currencies;

class Currency
{
    public static function all()
    {
        return collect(Currencies::getCurrencyCodes())
            ->filter(function ($item) {
                return Money::isValidCurrency($item);
            })
            ->map(function ($code) {
                return [
                    'code' => $code,
                    'symbol' => Currencies::getSymbol($code),
                ];
            })
            ->toArray();
    }
}
