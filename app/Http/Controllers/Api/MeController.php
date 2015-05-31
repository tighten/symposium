<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MeController extends BaseController
{
    public function index()
    {
        $me = App::make('Symposium\ApiEntities\Me', [Auth::user()]);

        return response()->jsonApi([
            'data' => [
                'id' => $me->id,
                'type' => $me->type,
                'attributes' => $me->attributes()
            ]
        ]);
    }
}
