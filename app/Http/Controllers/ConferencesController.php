<?php

namespace App\Http\Controllers;

use App\Conference;
use App\Exceptions\ValidationException;
use App\Services\CreateConferenceForm;
use App\Transformers\TalkForConferenceTransformer as TalkTransformer;
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
        'location' => [],
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
                $conferences = auth()->user()->favoritedConferences()->approved()->get();
                break;
            case 'dismissed':
                $conferences = auth()->user()->dismissedConferences()->approved()->get();
                break;
            case 'open_cfp':
                $conferences = Conference::undismissed()->openCfp()->approved()->get();
                break;
            case 'unclosed_cfp':
                $conferences = Conference::undismissed()->unclosedCfp()->approved()->get();
                break;
            case 'all':
                $conferences = Conference::undismissed()->approved()->get();
                break;
            case 'future':
                // Pass through
            default:
                $conferences = Conference::undismissed()->future()->approved()->get();
        }

        switch ($request->input('sort')) {
            case 'date':
                $conferences = $conferences->sortBy->starts_at;
                break;
            case 'opening_next':
                // Force CFPs with no CFP start date to the end
                $conferences = $conferences->sortBy(function ($conference) {
                    return isset($conference->cfp_starts_at) ? $conference->cfp_starts_at : Carbon::now()->addCentury();
                });
                break;
            case 'alpha':
                $conferences = $conferences->sortBy->title;
                break;
            case 'closing_next':
                // pass through
            default:
                // Force CFPs with no CFP end date to the end
                $conferences = $conferences->sortBy(function ($conference) {
                    return isset($conference->cfp_ends_at) ? $conference->cfp_ends_at : Carbon::now()->addCentury();
                });
                break;
        }

        return view('conferences.index', [
            'conferences' => $conferences,
        ]);
    }

    public function create()
    {
        return view('conferences.create', [
            'conference' => new Conference,
        ]);
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

        $talks = auth()->user()->talks->map(function ($talk) use ($conference) {
            return TalkTransformer::transform($talk, $conference);
        });

        return view('conferences.show', [
            'conference' => $conference,
            'talks' => $talks,
        ]);
    }

    public function edit($id)
    {
        $conference = Conference::findOrFail($id);

        if ($conference->author_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            Log::error('User ' . auth()->user()->id . " tried to edit a conference they don't own.");

            return redirect('/');
        }

        return view('conferences.edit', [
            'conference' => $conference,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->conference_rules);

        // @todo Update this to use ACL... gosh this app is old...
        $conference = Conference::findOrFail($id);

        if ($conference->author_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            Log::error('User ' . auth()->user()->id . " tried to edit a conference they don't own.");

            return redirect('/');
        }

        // Save
        $conference->fill($request->all(['title', 'description', 'location', 'url', 'cfp_url']));

        foreach (['starts_at', 'ends_at', 'cfp_starts_at', 'cfp_ends_at'] as $col) {
            $conference->$col = $request->input($col) ?: null;
        }

        if (auth()->user()->isAdmin()) {
            $conference->is_shared = $request->input('is_shared');
            $conference->is_approved = $request->input('is_approved');
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
            Log::error('User ' . auth()->user()->id . " tried to delete a conference that doesn't exist or they don't own.");

            return redirect('/');
        }

        $conference->delete();

        Session::flash('success-message', 'Conference successfully deleted.');

        return redirect('conferences');
    }

    public function dismiss($conferenceId)
    {
        if (Conference::findOrFail($conferenceId)->isFavorited()) {
            return redirect()->back();
        }

        auth()->user()->dismissedConferences()->attach($conferenceId);

        return redirect()->back();
    }

    public function undismiss($conferenceId)
    {
        auth()->user()->dismissedConferences()->detach($conferenceId);

        return redirect()->back();
    }

    public function favorite($conferenceId)
    {
        if (Conference::findOrFail($conferenceId)->isDismissed()) {
            return redirect()->back();
        }

        auth()->user()->favoritedConferences()->attach($conferenceId);

        return redirect()->back();
    }

    public function unfavorite($conferenceId)
    {
        auth()->user()->favoritedConferences()->detach($conferenceId);

        return redirect()->back();
    }

    private function showPublic($id)
    {
        $conference = Conference::approved()->findOrFail($id);

        return view('conferences.showPublic', [
            'conference' => $conference,
        ]);
    }
}
