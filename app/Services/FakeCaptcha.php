<?php

namespace App\Services;

use Captcha\Captcha;

class FakeCaptcha extends Captcha
{
    public function __construct(protected $valid = true)
    {
    }

    public static function invalid()
    {
        return new static(false);
    }

    public function check($captchaResponse = false)
    {
        return $this;
    }

    public function isValid()
    {
        return $this->valid;
    }
}
