<?php namespace Symposium\oAuthGuard\Facades;

use Illuminate\Support\Facades\Facade;

class oAuthGuard extends Facade
{
    protected static function getFacadeAccessor() {
        return 'oAuthGuard';
    }
}
