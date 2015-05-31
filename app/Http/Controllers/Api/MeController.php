<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

class MeController extends BaseController
{
    public function index()
    {
        $user = Auth::user();

        return $this->quickJsonApiReturn($user, 'users');
    }
}
