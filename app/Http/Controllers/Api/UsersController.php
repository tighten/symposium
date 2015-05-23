<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Talk;

class UsersController extends BaseController
{
    /**
     * Display all of the current user's talks
     *
     * @return Response
     */
    public function talks()
    {
        $talks = Talk::where('author_id', Auth::user()->id)
            ->get();

        return $this->quickJsonApiReturn($talks, 'talks');
    }
}
