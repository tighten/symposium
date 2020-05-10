<?php

namespace App\Validators;

use Illuminate\Validation\Validator;

class OnOrAfterValidator
{
    /**
     * Validate if the date is the same, or after another date.
     *
     * @param           $attribute
     * @param           $value
     * @param           $parameters
     * @param Validator $validator
     *
     * @return bool
     */
    public function validate($attribute, $value, array $parameters, Validator $validator)
    {
        if (! is_string($value) && ! is_numeric($value) && ! $value instanceof DateTimeInterface) {
            return false;
        }

        $data = $validator->getData();
        if (empty($parameters[0]) || empty($data[$parameters[0]])) {
            return false;
        }
        $date = $this->getDateTimestamp($data[$parameters[0]]);

        return $this->getDateTimestamp($value) >= $date;
    }

    /**
     * Get the date timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function getDateTimestamp($value)
    {
        return $value instanceof DateTimeInterface ? $value->getTimestamp() : strtotime($value);
    }

    /**
     * Generate message to display to the user on validation fail.
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     *
     * @return mixed
     */
    public function message($message, $attribute, $rule, array $parameters)
    {
        return str_replace('_', ' ', 'The '.$attribute.' field must be a date on or after the '.$parameters[0].' field.');
    }
}
