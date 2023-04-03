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
        if (! preg_match('/\d+([.,]?\d*)*/', $value)) {
            $fail($this->formatErrorMessage($attribute));
            return;
        }

        $valueHasPunctuation = Str::of($value)->contains([',', '.']);

        try {
            Money::parse($value, $this->data['speaker_package']['currency'], ! $valueHasPunctuation, App::currentLocale())->getAmount();
        } catch (ParserException $e) {
            $fail($this->formatErrorMessage($attribute));
        }
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    private function formatErrorMessage($attribute)
    {
        return str('{attribute} amount is invalid. Please update formatting and try again.')
            ->replace(
                '{attribute}',
                str($attribute)->replace('.', '_')->headline(),
            );
    }
}
