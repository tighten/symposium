<?php namespace Symposium\Http\Controllers;

use Auth;
use Exception;
use Input;
use Log;
use Redirect;
use Session;
use Talk;
use TalkVersion;
use TalkVersionRevision;
use Validator;
use View;

class TalkVersionsController extends BaseController
{
    protected $rules = [
        'nickname' => 'required',
        'title' => 'required',
        'type' => 'required',
        'level' => 'required',
        'length' => 'required|integer|min:0',
    ];

    /**
     * Show the specified version of the specified resource
     *
     * @param string $talkId
     * @param string $versionId
     * @return Response
     */
    public function show($talkId, $versionId)
    {
        try {
            $version = TalkVersion::where('id', $versionId)->firstOrFail();
            if ($version->talk->id != $talkId) {
                throw new Exception("User tried to visit version $versionId that doesn't match with provided talk $talkId.");
            }
        } catch (Exception $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($version->talk->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to view a talk they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('talks.versions.show')
            ->with('version', $version)
            ->with('current', $version->current())
            ->with('author', $version->talk->author);
    }

    public function showPublic($shareId)
    {
        try {
            // @todo: look it up using md5($version id . getenv('url_salt') . somethign else here) by probably caching a lookup table or something?
            // $version = TalkVersion::where('share_id', $shareId)->firstOrFail();
            $all = TalkVersion::all();

            $version = $all->filter(function($item) use($shareId) {
                return $item->public_id == $shareId;
            })->first();

            if (! $version) {
                throw new \Exception('test');
            }
        } catch (Exception $e) {
            \Log::error('Invalid share id visited: ' . $shareId);
            dd('Sorry, that share ID is invalid.');
        }

        return View::make('talks.versions.public-show')
            ->with('version', $version)
            ->with('current', $version->current())
            ->with('author', $version->talk->author);
    }

    public function showRevision($talkId, $versionId, $revisionId)
    {
        dd('not programmed yet :/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($talkId)
    {
        // @todo: Handle exceptions
        $talk = Talk::findOrFail($talkId);

        return View::make('talks.versions.create')
            ->with('talk', $talk)
            ->with('version', new TalkVersion)
            ->with('current', new TalkVersionRevision);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($talkId)
    {
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->passes()) {

            try {
                $talk = Talk::findOrFail($talkId);
            } catch (Exception $e) {
                Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
                Log::error($e);
                return Redirect::to('/');
            }

            if ($talk->author->id != Auth::user()->id) {
                Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
                Log::error('User ' . Auth::user()->id . ' tried to add a version to a talk they don\'t own.');
                return Redirect::to('/');
            }

            // Save
            $version = new TalkVersion;
            $version->nickname = Input::get('nickname');
            $version->talk_id = $talkId;
            $version->save();

            $revision = new TalkVersionRevision;
            $revision->title = Input::get('title');
            $revision->type = Input::get('type');
            $revision->length = Input::get('length');
            $revision->level = Input::get('level');
            $revision->description = Input::get('description');
            $revision->outline = Input::get('outline');
            $revision->organizer_notes = Input::get('organizer_notes');
            $revision->talk_version_id = $version->id;
            $revision->save();

            Session::flash('message', 'Successfully created new talk version.');

            return Redirect::to('/talks/' . $talkId . '/versions/' . $version->id);
        }

        return Redirect::to("talks/$talkId/createVersion")
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  str  $talkId
     * @param  str  $versionId
     * @return Response
     */
    public function edit($talkId, $versionId)
    {
        try {
            $version = TalkVersion::where('id', $versionId)->firstOrFail();
            if ($version->talk->id != $talkId) {
                throw new Exception("User tried to visit version $versionId that doesn't match with provided talk $talkId.");
            }
        } catch (Exception $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($version->talk->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('talks.versions.edit')
            ->with('current', $version->current())
            ->with('version', $version);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  str  $talkId
     * @param  str  $versionId
     * @return Response
     */
    public function update($talkId, $versionId)
    {
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->passes()) {
            // Pull
            $version = TalkVersion::where('id', $versionId)->firstOrFail();

            // Validate talk to version
            if ($version->talk->id != $talkId) {
                Session::flash('error-message', 'Error.');
                Log::error("User " . Auth::user()->id . " tried to visit version $versionId that doesn't match with provided talk $talkId.");
                return Redirect::to('/');
            }

            // Validate ownership
            if ($version->talk->author->id != Auth::user()->id) {
                Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
                Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
                return Redirect::to('/');
            }

            // Update Version
            $version->nickname = Input::get('nickname');
            $version->save();

            // Create new revision
            // @todo: Only create new revision if it's dirty
            $revision = new TalkVersionRevision;
            $revision->title = Input::get('title');
            $revision->type = Input::get('type');
            $revision->length = Input::get('length');
            $revision->level = Input::get('level');
            $revision->description = Input::get('description');
            $revision->outline = Input::get('outline');
            $revision->organizer_notes = Input::get('organizer_notes');
            $revision->talk_version_id = $version->id;
            $revision->save();

            Session::flash('message', 'Successfully edited talk version.');

            return Redirect::to('talks/' . $version->talk->id . '/versions/' . $version->id);
        }

        return Redirect::to('talks/' . $talkId . '/versions/' . $versionId . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Show the confirmation for deleting the specified resource
     *
     * @param  str  $id
     * @return Resource
     */
    public function delete($id)
    {
        dd('t');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str  $talkId
     * @param  str  $versionId
     * @return Response
     */
    public function destroy($talkId, $versionId)
    {
        $version = TalkVersion::where('id', $versionId)->firstOrFail();

        // Validate ownership
        if ($version->talk->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to delete a talk version they don\'t own.');
            return Redirect::to('/');
        }

        $redirect = 'talks/' . $version->talk->id;

        $version->delete();

        Session::flash('message', 'Successfully deleted talk version.');

        return Redirect::to($redirect);
    }
}
