<?php

namespace App\OAuthGuard;

use App\User;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthGuard
{
    private $authorizer;

    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    public function user()
    {
        return User::find($this->authorizer->getResourceOwnerId());
    }
}
