<?php namespace Symposium\OAuthGuard;

use LucaDegasperi\OAuth2Server\Authorizer;
use User;

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
