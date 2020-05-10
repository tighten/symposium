<?php

namespace App;

use Illuminate\Notifications\Notifiable as NotifiableTrait;

class TightenSlack
{
    use NotifiableTrait;

    /**
     * @return string|null
     */
    public function routeNotificationForSlack()
    {
        return config('app.slack_endpoint');
    }
}
