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
        $talk = Talk::where('id', $id)
                ->where('author_id', Auth::user()->id)
                ->firstOrFail();

        return $this->quickJsonApiReturn($talk, 'talks');
    }
}
