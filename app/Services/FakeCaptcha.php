<?php

namespace App\Services;

use Captcha\Captcha;

class FakeCaptcha extends Captcha
{
    public function check($captchaResponse = false)
    {
        return $this;
    }

    public function isValid()
    {
        return true;
    }
}
