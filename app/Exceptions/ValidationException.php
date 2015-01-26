<?php namespace SaveMyProposals\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{
    protected $errors;

    public function __construct($message, $errors)
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function errors()
    {
        return $this->errors;
    }
}

