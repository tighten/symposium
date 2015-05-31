<?php namespace Symposium\ApiResources;

use User;

class Me
{
    public $type = 'users';
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $created_at;
    public $updated_at;

    public function __construct(User $user)
    {
        foreach (['id', 'email', 'first_name', 'last_name', 'created_at', 'updated_at'] as $key) {
            $this->$key = $user->$key;
        }
    }

    public function attributes()
    {
        return [
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ];
    }
}
