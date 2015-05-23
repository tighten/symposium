<?php namespace Symposium\Http\Controllers\Api;

use Auth;
use Symposium\Http\Controllers\BaseController;
use Talk;

class TalksController extends BaseController
{
    public function __construct()
    {
        exit('program oauth');
        $this->beforeFilter(
            'auth'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return Response
     */
    public function show($id)
    {
        return Talk::where('id', $id)
            ->where('author_id', Auth::user()->id)
            ->firstOrFail();
    }
}
