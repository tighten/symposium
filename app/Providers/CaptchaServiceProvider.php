<?php

namespace App\Providers;

use Captcha\Captcha;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Captcha::class, function () {
            $captcha = new Captcha;
            $captcha->setPublicKey(env('CAPTCHA_PUBLIC'));
            $captcha->setPrivateKey(env('CAPTCHA_PRIVATE'));

            return $captcha;
        });
    }
}
