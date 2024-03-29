<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Bio;
use Illuminate\Support\Facades\Validator;

class CreateBioForm
{
    private $rules = [
        'nickname' => ['required'],
        'body' => ['required'],
        'public' => [],
    ];

    private $input;

    private $user;

    private function __construct($input, $user)
    {
        $this->input = $this->removeEmptyFields($input);

        $this->input['public'] = array_key_exists('public', $this->input) &&
            $this->input['public'] == '1';

        $this->user = $user;
    }

    public static function fillOut($input, $user)
    {
        return new self($input, $user);
    }

    public function complete()
    {
        $validation = Validator::make($this->input, $this->rules);

        if ($validation->fails()) {
            throw new ValidationException('Invalid input provided, see errors', $validation->errors());
        }

        return Bio::create(array_merge($this->input, [
            'user_id' => $this->user->id,
        ]));
    }

    private function removeEmptyFields($input)
    {
        return array_filter($input);
    }
}
