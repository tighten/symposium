<?php

namespace App\Rules;

use Cknow\Money\Money;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Money\Exception\ParserException;

class ValidAmountForCurrentLocale implements DataAwareRule, ValidationRule
{
    protected $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/\d+([.,]?\d*)*/', $value)) {
            $fail($this->formatErrorMessage($attribute));

            return;
        }

        $valueHasPunctuation = Str::of($value)->contains([',', '.']);

        try {
            Money::parse(
                $value,
                $this->data['speaker_package']['currency'],
                ! $valueHasPunctuation,
                App::currentLocale(),
            )->getAmount();
        } catch (ParserException $e) {
            $fail($this->formatErrorMessage($attribute));
        }
    }

    public function setData(array $data)
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
