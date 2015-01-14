<?php namespace SaveMyProposals\Http\Controllers;

use Auth;
use Input;
use Log;
use Redirect;
use Session;
use Talk;
use TalkVersion;
use TalkVersionRevision;
use Validator;
use View;

class TalksController extends BaseController
{
    // @todo: DRY against TalkVersionsController@$rules (but this doesn't need nickname)
    protected $rules = [
        'title' => 'required',
        'type' => 'required',
        'level' => 'required',
        'length' => 'required|integer|min:0',
    ];

    protected $sorting_talks = [
        'date' => '',
        'alpha' => '',
    ];

    public function __construct()
    {
        $this->beforeFilter(
            'auth'
        );
    }

    /**
     * Display all of the current user's talks
     *
     * @return Response
     */
    public function index()
    {
        $bold_style = 'style="font-weight: bold;"';

        $sorting_talk = $this->sorting_talks;

        switch (Input::get('sort')) {
            case 'date':
                $sorting_talk['date'] = $bold_style;
                $talks = Talk::orderBy('created_at', 'DESC')->currentUserOnly()->get();
                break;
            case 'alpha':
                // Pass through
            default:
                $sorting_talk['alpha'] = $bold_style;
                $talks = Talk::orderBy('title', 'ASC')->currentUserOnly()->get();
                break;
        }

        return View::make('talks.index')
            ->with('talks', $talks)
            ->with('sorting_talk', $sorting_talk);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('talks.create')
            ->with('version', new TalkVersion)
            ->with('current', new TalkVersionRevision);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make(Input::all(), $this->rules);

        if ($validator->passes()) {
            // @todo: DRY with TalkVersionsController@store, prob using commands

            // Save
            $talk = new Talk;
            $talk->title = Input::get('title');
            $talk->author_id = Auth::user()->id;
            $talk->save();

            $version = new TalkVersion;
            $version->nickname = 'Initial';
            $version->talk_id = $talk->id;
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

            Session::flash('message', 'Successfully created new talk.');

            return Redirect::to('/talks/' . $talk->id);
        }

        return Redirect::to('talks/create')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  str  $talkId
     * @return Response
     */
    public function edit($talkId)
    {
        try {
            $talk = Talk::where('id', $talkId)->firstOrFail();
        } catch (Exception $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        if ($talk->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('talks.edit')
            ->with('talk', $talk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  str  $talkId
     * @return Response
     */
    public function update($talkId)
    {
        $validator = Validator::make(Input::all(), [
            'title' => 'required'
        ]);

        if ($validator->passes()) {
            $talk = Talk::where('id', $talkId)->firstOrFail();

            // Validate ownership
            if ($talk->author->id != Auth::user()->id) {
                Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
                Log::error('User ' . Auth::user()->id . ' tried to edit a talk they don\'t own.');
                return Redirect::to('/');
            }

            $talk->title = Input::get('title');
            $talk->save();

            Session::flash('message', 'Successfully edited talk.');

            return Redirect::to('talks/' . $talk->id);
        }

        return Redirect::to('talks/' . $talkId . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $talk = Talk::where('id', $id)->firstOrFail();
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        // Validate ownership
        if ($talk->author->id != Auth::user()->id && ! Auth::user()->isAdmin()) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to show a talk they don\'t own.');
            return Redirect::to('/');
        }

        return View::make('talks.show')
            ->with('talk', $talk)
            ->with('author', $talk->author);
    }


    /**
     * Show the confirmation for deleting the specified resource
     *
     * @param  int  $id
     * @return Resource
     */
    public function delete($id)
    {
        dd('t');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $talk = Talk::where('id', $id)->firstOrFail();

        // Validate ownership
        if ($talk->author->id != Auth::user()->id) {
            Session::flash('error-message', 'Sorry, but you don\'t own that talk.');
            Log::error('User ' . Auth::user()->id . ' tried to delete a talk they don\'t own.');
            return Redirect::to('/');
        }

        $talk->delete();

        Session::flash('message', 'Successfully deleted talk.');

        return Redirect::to('talks');
    }
}
