<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use User;

class UserTalksController extends BaseController
{
    /**
     * Display all of the given user's talks
     *
     * @return Response
     */
    public function index($userId)
    {
        $talks = User::find($userId)->talks;

        return $this->quickJsonApiReturn($talks, 'talks');
    }
}
