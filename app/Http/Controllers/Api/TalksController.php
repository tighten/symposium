<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Talk;

class TalksController extends BaseController
{
    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return Response
     */
    public function show($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        return $this->quickJsonApiReturn($talk, 'talks');
    }
}
