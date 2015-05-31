<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use User;

class UserBiosController extends BaseController
{
    /**
     * Display all of the given user's bios
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != Auth::user()->id) {
            App::abort(404);
        }

        $bios = User::find($userId)->bios;

        return $this->quickJsonApiReturn($bios, 'bios');
    }
}
