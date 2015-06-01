<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symposium\Http\Controllers\BaseController as ParentBaseController;

class BaseController extends ParentBaseController
{
    public function __construct()
    {
        // exit('program oauth');
        $this->beforeFilter(
            'auth'
        );
    }
}
