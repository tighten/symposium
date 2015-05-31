<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

class TalksController extends BaseController
{
    public function show($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        $current = $talk->versions()->first()->current();

        foreach ($current->toArray() as $key => $value) {
            if ($key == 'id') continue;
            $talk->$key = $value;
        }

        return $this->quickJsonApiReturn($talk, 'talks');
    }
}
