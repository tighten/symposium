<?php

namespace App\Providers;

use Captcha\Captcha;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Captcha::class, function () {
            $captcha = new Captcha();
            $captcha->setPublicKey(config('services.google.captcha.public'));
            $captcha->setPrivateKey(config('services.google.captcha.private'));

            return $captcha;
        });
    }
}
