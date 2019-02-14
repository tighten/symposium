<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Exceptions\ValidationException;
use App\Services\CreateConferenceForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

    public function index(Request $request)
    {
        switch ($request->input('filter')) {
            case 'favorites':
                $conferences = auth()->user()->favoritedConferences()->get();
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

        switch ($request->input('sort')) {
            case 'date':
                $conferences = $conferences->sortBy->starts_at;
                break;
            case 'opening_next':
                // Force CFPs with no CFP start date to the end
                $conferences = $conferences->sortBy(function (Conference $model) {
                    return isset($model->cfp_starts_at) ? $model->cfp_starts_at : Carbon::now()->addCentury();
                });
                break;
            case 'alpha':
                $conferences = $conferences->sortBy->title;
                break;
            case 'closing_next':
                // pass through
            default:
                // Forces closed CFPs to the end.
                $conferences = $conferences->sortBy(function (Conference $model) {
                    // cfp with no end sorts in the middle
                    if (!isset($model->cfp_ends_at)) {
                        return $model->starts_at->addCentury();
                    }

                    // cfp ending in the past sorts at the bottom
                    if ($model->cfp_ends_at->isPast()) {
                        return $model->starts_at->addCenturies(2);
                    }

                    // cfp ending in the future sort at the top
                    return $model->cfp_ends_at;
                });
                break;
        }

        return view('conferences.index')
            ->with('conferences', $conferences);
    }

    public function create()
    {
        return view('conferences.create')
            ->with('conference', new Conference);
    }

    public function store(Request $request)
    {
        $form = CreateConferenceForm::fillOut($request->all(), auth()->user());

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

    public function show($id)
    {
        if (auth()->guest()) {
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
            ->with('talks', auth()->user()->talks);
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
            $conference = auth()->user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error("User " . auth()->user()->id . " tried to edit a conference they don't own.");
            return redirect('/');
        }

        return view('conferences.edit')
            ->with('conference', $conference);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->conference_rules);

        try {
            $conference = auth()->user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error("User " . auth()->user()->id . " tried to edit a conference they don't own.");
            return redirect('/');
        }

        // Save
        $conference->fill($request->only(['title', 'description', 'url', 'cfp_url']));

        foreach (['starts_at', 'ends_at', 'cfp_starts_at', 'cfp_ends_at'] as $col) {
            $conference->$col = $request->input($col) ?: null;
        }

        $conference->save();

        Session::flash('message', 'Successfully edited conference.');

        return redirect('conferences/' . $conference->id);
    }

    public function destroy($id)
    {
        try {
            $conference = auth()->user()->conferences()->findOrFail($id);
        } catch (Exception $e) {
            Log::error("User " . auth()->user()->id . " tried to delete a conference that doesn't exist or they don't own.");
            return redirect('/');
        }

        $conference->delete();

        Session::flash('success-message', 'Conference successfully deleted.');

        return redirect('conferences');
    }

    public function favorite($conferenceId)
    {
        auth()->user()->favoritedConferences()->attach($conferenceId);

        return redirect()->back();
    }

    public function unfavorite($conferenceId)
    {
        auth()->user()->favoritedConferences()->detach($conferenceId);

        return redirect()->back();
    }
}
