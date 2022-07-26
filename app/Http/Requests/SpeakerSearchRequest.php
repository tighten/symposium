<?php

namespace App\Http\Requests;

use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class SpeakerSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function prepareForValidation()
    {
        optional(State::abbreviation($this->input('query')), function ($value) {
            $this->merge(['query' => $value]);
        });
    }
}
