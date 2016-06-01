<?php namespace App\Services;

use Bio;
use App\Exceptions\ValidationException;
use Validator;

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
        $this->user = $user;
    }

    private function removeEmptyFields($input)
    {
        return array_filter($input);
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
}
