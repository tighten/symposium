<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UuidBase extends Eloquent
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
