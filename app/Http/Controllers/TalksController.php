<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Log;
use Redirect;
use Session;
use Talk;
use TalkRevision;
use App\User;
use Validator;
use View;

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

    protected $sorting_talks = [
        'date' => '',
        'alpha' => '',
    ];

    public function index()
    {
        $talks = Auth::user()->talks()->active()->get();
        list($talks, $sorting_talk) = $this->sortTalks($talks);

        return View::make('talks.index')
            ->with('talks', $talks)
            ->with('sorting_talk', $sorting_talk);
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

    public function edit($talkId)
    {
        try {
            $talk = Auth::user()->talks()->findOrFail($talkId);
        } catch (Exception $e) {
            Session::flash('error-message', 'Sorry, but that isn\'t a valid URL.');
            Log::error($e);
            return Redirect::to('/');
        }

        return View::make('talks.edit')
            ->with('talk', $talk)
            ->with('current', $talk->current());
    }

    public function update($talkId)
    {
        $validator = Validator::make(Input::all(), $this->rules, $this->messages);

        if ($validator->passes()) {
            $talk = Auth::user()->talks()->findOrFail($talkId);
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

        return Redirect::to('talks/' . $talkId . '/edit')
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
        $talks =  Auth::user()->talks()->archived()->get();
        list($talks, $sorting_talk) = $this->sortTalks($talks);

        return View::make('talks.archive')
          ->with('talks', $talks)
          ->with('sorting_talk', $sorting_talk);
    }

    public function archive($id)
    {
        $talk = Auth::user()->talks()->findOrFail($id);
        $talk->is_archived = true;
        $talk->save();

        Session::flash('message', 'Successfully archived talk.');

        return Redirect::to('talks');
    }

    public function restore($talkId)
    {
        $talk = Auth::user()->talks()->findOrFail($talkId);
        $talk->is_archived = false;
        $talk->save();

        Session::flash('message', 'Successfully restored talk.');

        return Redirect::to('archive');
    }

  /**
   * Sorts through talks and returns an array of variables. Access the variables using the list() construct.
   * @param  string $type Whether the index is for archived talks or active talks
   * @return array       Returns array of variables.
   */
    private function sortTalks($talks)
    {
        $bold_style = 'style="font-weight: bold;"';

        $sorting_talk = $this->sorting_talks;

        switch (Input::get('sort')) {
            case 'date':
                $sorting_talk['date'] = $bold_style;
                $talks = $talks->sortByDesc('created_at');
                break;
            case 'alpha':
            // Pass through
            default:
                $sorting_talk['alpha'] = $bold_style;
                $talks = $talks->sortBy(function ($talk) {
                    return strtolower($talk->current()->title);
                });
                break;
        }
        return [$talks, $sorting_talk];
    }
}
