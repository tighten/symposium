<?php

namespace App\Http\Requests;

use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class SpeakerSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function prepareForValidation()
    {
        optional(State::abbreviation($this->query('query')), function ($value) {
            $this->merge([
                'query' => $value,
                'original' => $this->query('query'),
            ]);
        });
    }
}
