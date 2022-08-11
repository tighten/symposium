<?php

namespace App\Rules;

use Cknow\Money\Money;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Money\Exception\ParserException;

class ValidAmountForCurrentLocale implements DataAwareRule, InvokableRule
{
    protected $data = [];

    public function __invoke($attribute, $value, $fail)
    {
        if (! preg_match("/\d+([.,]?\d*)*/", $value)) {
            $fail($attribute . ' amount is invalid. Please check formatting and try again.');
        }

        $valueHasPunctuation = Str::of($value)->contains([',', '.']);

        try {
            Money::parse($value, $this->data['speaker_package']['currency'], ! $valueHasPunctuation, App::currentLocale())->getAmount();
        } catch (ParserException $e) {
            $fail($attribute . ' amount is invalid. Please check formatting and try again.');
        }
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
