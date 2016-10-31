<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use JoindIn\Client;
use App\Exceptions\ValidationException;
use App\Services\CreateConferenceForm;

class ConferencesController extends BaseController
{
    protected $conference_rules = [
        'title' => ['required'],
        'description' => ['required'],
        'url' => ['required'],
        'cfp_url' => [],
        'starts_at' => ['date'],
        'ends_at' => ['date', 'onOrAfter:starts_at'],
        'cfp_starts_at' => ['date', 'before:starts_at'],
        'cfp_ends_at' => ['date', 'after:cfp_starts_at', 'before:starts_at'],
    ];

    /**
     * Display all conferences
     *
     * @return Response
     */
    public function index()
    {
        switch (Input::get('filter')) {
            case 'favorites':
                $conferences = Auth::user()->favoritedConferences()->get();
                break;
            case 'open_cfp':
                $conferences = Conference::openCfp()->get();
                break;
            case 'unclosed_cfp':
                $conferences = Conference::unclosedCfp()->get();
                break;
            case 'all':
                $conferences = Conference::all();
                break;
            case 'future':
                // Pass through
            default:
                $conferences = Conference::future()->get();
        }

        switch (Input::get('sort')) {
            case 'date':
                $conferences = $conferences->sortBy(function (Conference $model) {
                    return $model->starts_at;
                });
                break;
            case 'closing_next':
                // Forces closed CFPs to the end. I feel dirty. Even dirtier with the 500 thing.
                $conferences = $conferences
                    ->sortBy(function (Conference $model) {
                        if ($model->cfp_ends_at > Carbon::now()) {
                            return $model->cfp_ends_at;
                        } elseif ($model->cfp_ends_at === null) {
                            return Carbon::now()->addYear(500);
                        } else {
                            return $model->cfp_ends_at->addYear(1000);
                        }
                    });
                break;
            case 'alpha':
                // Pass through
            default:
                $conferences = $conferences->sortBy(function (Conference $model) {
                    return strtolower($model->title);
                });
                break;
        }

        return view('conferences.index')
            ->with('conferences', $conferences);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('conferences.create')
            ->with('conference', new Conference());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $form = CreateConferenceForm::fillOut(Input::all(), Auth::user());

        try {
            $conference = $form->complete();
        } catch (ValidationException $e) {
            return redirect('conferences/create')
                ->withErrors($e->errors())
                ->withInput();
        }

        Session::flash('message', 'Successfully created new conference.');

        return redirect('conferences/' . $conference->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        if (Auth::guest()) {
            return $this->showPublic($id);
        }

        try {
            $conference = Conference::findOrFail($id);
        } catch (Exception $e) {
            return redirect('/');
        }

        $talksAtConference = $conference->myTalks()->map(function ($talkRevision) {
            return $talkRevision->talk->id;
        });

        return view('conferences.show')
            ->with('conference', $conference)
            ->with('talksAtConference', $talksAtConference)
            ->with('talks', Auth::user()->talks);
    }

    private function showPublic($id)
    {
        $conference = Conference::findOrFail($id);

        return view('conferences.showPublic')
            ->with('conference', $conference);
    }

    public function edit($id)
    {
        try {
            $conference = Auth::user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error('User ' . Auth::user()->id . ' tried to edit a conference they don\'t own.');
            return redirect('/');
        }

        return view('conferences.edit')
            ->with('conference', $conference);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->conference_rules);

        try {
            $conference = Auth::user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error('User ' . Auth::user()->id . ' tried to edit a conference they don\'t own.');
            return redirect('/');
        }

        // Default to null
        foreach (['starts_at', 'ends_at', 'cfp_starts_at', 'cfp_ends_at'] as $col) {
            $nullableDates[$col] = $request->input($col) ?: null;
        }

        // Save
        $conference->fill($request->only(['title', 'description', 'url', 'cfp_url']));
        $conference->fill($nullableDates);
        $conference->save();

        Session::flash('message', 'Successfully edited conference.');

        return redirect('conferences/' . $conference->id);
    }

    public function destroy($id)
    {
        try {
            $conference = Auth::user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error("User " . Auth::user()->id . " tried to delete a conference that doesn't exist or they don't own.");
            return redirect('/');
        }

        $conference->delete();
        Session::flash('success-message', 'Conference successfully deleted.');

        return redirect('conferences');
    }

    public function favorite($conferenceId)
    {
        Auth::user()->favoritedConferences()->attach($conferenceId);

        return redirect()->back();
    }

    public function unfavorite($conferenceId)
    {
        Auth::user()->favoritedConferences()->detach($conferenceId);

        return redirect()->back();
    }
}
