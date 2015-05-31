<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

class TalksController extends BaseController
{
    public function show($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        return $this->quickJsonApiReturn($talk, 'talks');
    }
}
