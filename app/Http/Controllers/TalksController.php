<?php

namespace App\Http\Controllers;

use App\Talk;
use App\TalkRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function index(Request $request)
    {
        $talks = $this->sortTalks(
            Auth::user()->talks()->active()->get(),
            $request->input('sort')
        );

        return view('talks.index')
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

        return view('talks.create', ['current' => $current, 'talk' => $talk]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->passes()) {
            // Save
            $talk = Talk::create([
                'author_id' => Auth::user()->id,
                'public' => $request->input('public') == 'yes',
            ]);

            $revision = TalkRevision::create([
                'title' => $request->input('title'),
                'type' => $request->input('type'),
                'length' => $request->input('length'),
                'level' => $request->input('level'),
                'description' => $request->input('description'),
                'slides' => $request->input('slides'),
                'organizer_notes' => $request->input('organizer_notes'),
                'talk_id' => $talk->id,
            ]);

            Session::flash('message', 'Successfully created new talk.');

            return redirect('/talks/' . $talk->id);
        }

        return redirect('talks/create')
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
            return redirect('/');
        }

        return view('talks.edit')
            ->with('talk', $talk)
            ->with('current', $talk->current());
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);



        if ($validator->passes()) {
            $talk = Auth::user()->talks()->findOrFail($id);
            $talk->update(['public' => $request->input('public') == 'yes']);

            $revision = TalkRevision::create([
                'title' => $request->input('title'),
                'type' => $request->input('type'),
                'length' => $request->input('length'),
                'level' => $request->input('level'),
                'description' => $request->input('description'),
                'slides' => $request->input('slides'),
                'organizer_notes' => $request->input('organizer_notes'),
                'talk_id' => $talk->id,
            ]);

            Session::flash('message', 'Successfully edited talk.');

            return redirect('talks/' . $talk->id);
        }

        return redirect('talks/' . $id . '/edit')
            ->withErrors($validator)
            ->withInput();
    }

    public function show($id, Request $request)
    {
        $talk = Auth::user()->talks()->findOrFail($id);

        $current = $request->filled('revision') ? $talk->revisions()->findOrFail($request->input('revision')) : $talk->current();

        return view('talks.show')
            ->with('talk', $talk)
            ->with('showingRevision', $request->filled('revision'))
            ->with('current', $current);
    }

    public function destroy($id)
    {
        Auth::user()->talks()->findOrFail($id)->delete();

        Session::flash('message', 'Successfully deleted talk.');

        return redirect('talks');
    }

    public function archiveIndex(Request $request)
    {
        $talks = $this->sortTalks(
            Auth::user()->talks()->archived()->get(),
            $request->input('sort')
        );

        return view('talks.archive')
          ->with('talks', $talks)
          ->with('sorted_by', $this->sorted_by);
    }

    public function archive($id)
    {
        Auth::user()->talks()->findOrFail($id)->archive();

        Session::flash('message', 'Successfully archived talk.');

        return redirect('talks');
    }

    public function restore($id)
    {
        Auth::user()->talks()->findOrFail($id)->restore();

        Session::flash('message', 'Successfully restored talk.');

        return redirect('archive');
    }

    private function sortTalks($talks, $sort)
    {
        switch ($sort) {
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
