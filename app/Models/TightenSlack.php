<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable as NotifiableTrait;

class TightenSlack
{
    use NotifiableTrait;

    public function getKey()
    {
        return 1;
    }

    /**
     * @codeCoverageIgnore
     */
    public function routeNotificationForSlack(): ?string
    {
        return config('app.slack_endpoint');
    }
}
