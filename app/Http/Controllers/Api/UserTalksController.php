<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        if ($userId != Auth::user()->id) {
            App::abort(404);
        }

        $talks = User::find($userId)->talks;

        foreach ($talks as &$talk) {
            $current = $talk->versions()->first()->current();

            foreach ($current->toArray() as $key => $value) {
                if ($key == 'id') continue;
                $talk->$key = $value;
            }
        }

        return $this->quickJsonApiReturn($talks, 'talks');
    }
}
