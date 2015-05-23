<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Symposium\Http\Controllers\BaseController;
use Talk;

class UsersController extends BaseController
{
    public function __construct()
    {
        exit('program oauth');
        $this->beforeFilter(
            'auth'
        );
    }

    /**
     * Display all of the current user's talks
     *
     * @return Response
     */
    public function talks()
    {
        return Talk::where('author_id', Auth::user()->id)
            ->get();
    }
}
