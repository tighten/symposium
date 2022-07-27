<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveConferenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $speakerPackage = [];

        /*
        * Truncate decimal values to 2 places and 
        * convert values to whole numbers for storage
        */

        $speakerPackage['travel'] = round($this->speaker_package['travel'], 2) * 100;
        $speakerPackage['food'] = round($this->speaker_package['food'], 2) * 100;
        $speakerPackage['hotel'] = round($this->speaker_package['hotel'], 2) * 100;

        $this->merge([
            'speaker_package' => json_encode($speakerPackage),
        ]);
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
        ];
    }

    public function checkSpeakerPackage()
    {
        /* steps
        * are these values numeric?
        * are they of the right value for a given currency type
        */
        $speakerPackage = [];

        // Convert any decimal values to whole numbers for storage
        $speakerPackage['travel'] = round($this->speaker_package['travel'], 2) * 100;
        $speakerPackage['food'] = round($this->speaker_package['food'], 2) * 100;
        $speakerPackage['hotel'] = round($this->speaker_package['hotel'], 2) * 100;

        $this->merge([
            'speaker_package' => json_encode($this->speaker_package),
        ]);
        dd('here chekcing speaker package');
    }
}
