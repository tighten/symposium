<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

class BiosController extends BaseController
{
    public function show($id)
    {
        $bio = Auth::user()->bios()->findOrFail($id);

        return $this->quickJsonApiReturn($bio, 'bios');
    }
}
