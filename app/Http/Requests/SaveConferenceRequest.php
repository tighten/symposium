<?php

namespace App\Http\Requests;

use App\Rules\ValidAmountForCurrentLocale;
use Illuminate\Foundation\Http\FormRequest;
use Cknow\Money\Money;

class SaveConferenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'url' => ['required', 'url'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'has_cfp' => ['boolean'],
            'cfp_url' => ['nullable', 'prohibited_if:has_cfp,false', 'url'],
            'cfp_starts_at' => [
                'nullable',
                'prohibited_if:has_cfp,false',
                'date',
                'before:starts_at',
            ],
            'cfp_ends_at' => [
                'nullable',
                'prohibited_if:has_cfp,false',
                'date',
                'after:cfp_starts_at',
                'before:starts_at',
            ],
            'location' => ['nullable'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'speaker_package' => ['nullable'],
            'speaker_package.currency' => function ($attribute, $value, $fail) {
                if (!Money::isValidCurrency($value)) {
                    $fail($attribute . ' must be a valid currency type.');
                };
            },
            'speaker_package.travel' => [
                'nullable',
                new ValidAmountForCurrentLocale(),
            ],
            'speaker_package.food' => [
                'nullable',
                new ValidAmountForCurrentLocale(),
            ],
            'speaker_package.hotel' => [
                'nullable',
                new ValidAmountForCurrentLocale(),
            ],
        ];
    }
}
