<?php namespace App\Http\Controllers;

use Log;
use Auth;
use Talk;
use View;
use Input;
use Session;
use App\Models\User;
use Redirect;
use Validator;
use TalkRevision;

class TalksController extends BaseController
{
    protected $rules = [
        'title' => 'required',
        'type' => 'required',
        'level' => 'required',
        'length' => 'required|integer|min:0',
        'slides' => 'url',
    ];

    protected $messages = [
        'slides.url' => 'Slides URL must contain a valid URL',
    ];

    protected $sorted_by = 'alpha';

    public function index()
    {
        $talks = $this->sortTalks(
            Auth::user()->talks()->active()->get()
        );

        return View::make('talks.index')
            ->with('talks', $talks)
            ->with('sorted_by', $this->sorted_by);
    }

    public function create()
    {
        $current = new TalkRevision([
            'type' => 'seminar',
            'level' => 'beginner',
        ]);
        $talk = new Talk;

        return View::make('talks.create', compact('current', 'talk'));
    }

    public function store()
    {
        $validator = Validator::make(Input::all(), $this->rules, $this->messages);

        if ($validator->passes()) {
            // Save
            $talk = new Talk;
            $talk->author_id = Auth::user()->id;
            $talk->public = Input::get('public') == 'yes';
            $talk->save();

            $revision = new TalkRevision;
            $revision->title = Input::get('title');
            $revision->type = Input::get('type');
            $revision->length = Input::get('length');
            $revision->level = Input::get('level');
            $revision->description = Input::get('description');
            $revision->slides = Input::get('slides');
            $revision->organizer_notes = Input::get('organizer_notes');
            $revision->talk_id = $talk->id;
            $revision->save();

            Session::flash('message', 'Successfully created new talk.');

            return Redirect::to('/talks/' . $talk->id);
        }

        return Redirect::to('talks/create')
            ->withErrors($validator)
            ->withInput();
    }

    public function edit($id)
    {
        try {
            $talk = Auth::user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        return View::make('talks.edit')
            ->with('talk', $talk)
            ->with('current', $talk->current());
    }

    public function update($id)
    {
        $validator = Validator::make(Input::all(), $this->rules, $this->messages);

        if ($validator->passes()) {
            $talk = Auth::user()->talks()->findOrFail($id);
            $talk->public = Input::get('public') == 'yes';
            $talk->save();

            $revision = new TalkRevision;
            $revision->title = Input::get('title');
            $revision->type = Input::get('type');
            $revision->length = Input::get('length');
            $revision->level = Input::get('level');
            $revision->description = Input::get('description');
            $revision->slides = Input::get('slides');
            $revision->organizer_notes = Input::get('organizer_notes');
            $revision->talk_id = $talk->id;
            $revision->save();

            Session::flash('message', 'Successfully edited talk.');

            return Redirect::to('talks/' . $talk->id);
        }

        return Redirect::to('talks/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    public function show($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        $current = Input::has('revision') ? $talk->revisions()->findOrFail(Input::get('revision')) : $talk->current();

        return View::make('talks.show')
            ->with('talk', $talk)
            ->with('showingRevision', Input::has('revision'))
            ->with('current', $current);
    }

    public function destroy($id)
    {
        Auth::user()->talks()->findOrFail($id)->delete();

        Session::flash('message', 'Successfully deleted talk.');

        return Redirect::to('talks');
    }

    public function archiveIndex()
    {
        $talks = $this->sortTalks(
            Auth::user()->talks()->archived()->get()
        );

        return View::make('talks.archive')
          ->with('talks', $talks)
          ->with('sorted_by', $this->sorted_by);
    }

    public function archive($id)
    {
        Auth::user()->talks()->findOrFail($id)->archive();

        Session::flash('message', 'Successfully archived talk.');

        return Redirect::to('talks');
    }

    public function restore($id)
    {
        Auth::user()->talks()->findOrFail($id)->restore();

        Session::flash('message', 'Successfully restored talk.');

        return Redirect::to('archive');
    }

    private function sortTalks($talks)
    {
        switch (Input::get('sort')) {
            case 'date':
                $this->sorted_by = 'date';
                return $talks->sortByDesc('created_at');
                break;
            case 'alpha':
            // Pass through
            default:
                $this->sorted_by = 'alpha';
                return $talks->sortBy(function ($talk) {
                    return strtolower($talk->current()->title);
                });
                break;
        }
    }
}
