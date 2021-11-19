<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'cfp_url' => ['nullable', 'url'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'cfp_starts_at' => ['nullable', 'date', 'before:starts_at'],
            'cfp_ends_at' => ['nullable', 'date', 'after:cfp_starts_at', 'before:starts_at'],
            'location' => ['nullable'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
        ];
    }
}
