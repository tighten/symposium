<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveTalkRequest;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TalksController extends Controller
{
    protected $sorted_by = 'alpha';

    public function index(Request $request): View
    {
        $talks = $this->sortTalks(
            $this->filterTalks($request->input('filter')),
            $request->input('sort')
        );

        return view('talks.index', [
            'talks' => $talks,
            'sorted_by' => $this->sorted_by,
        ]);
    }

    public function create(): View
    {
        $current = new TalkRevision([
            'type' => 'seminar',
            'level' => 'beginner',
        ]);
        $talk = new Talk;

        return view('talks.create', ['current' => $current, 'talk' => $talk]);
    }

    public function store(SaveTalkRequest $request): RedirectResponse
    {
        $talk = Talk::create([
            'author_id' => auth()->user()->id,
            'public' => $request->input('public') == '1',
        ]);

        TalkRevision::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'length' => $request->input('length'),
            'level' => $request->input('level'),
            'description' => $request->input('description'),
            'slides' => $request->input('slides'),
            'organizer_notes' => $request->input('organizer_notes'),
            'talk_id' => $talk->id,
        ]);

        Session::flash('success-message', 'Successfully created new talk.');

        return redirect("/talks/{$talk->id}");
    }

    public function show($id, Request $request): View
    {
        $talk = auth()->user()->talks()->findOrFail($id)->loadCurrentRevision();

        $current = $request->filled('revision')
            ? $talk->revisions()->findOrFail($request->input('revision'))
            : $talk->currentRevision;

        $submissions = Submission::where('talk_revision_id', $current->id)
            ->with(['conference', 'acceptance', 'rejection'])
            ->get();

        return view('talks.show', [
            'talk' => $talk,
            'showingRevision' => $request->filled('revision'),
            'current' => $current,
            'submissions' => $submissions,
        ]);
    }

    public function edit($id)
    {
        $talk = auth()->user()->talks()->withCurrentRevision()->findOrFail($id);

        return view('talks.edit', [
            'talk' => $talk,
            'current' => $talk->currentRevision,
        ]);
    }

    public function update($id, SaveTalkRequest $request): RedirectResponse
    {
        $talk = auth()->user()->talks()->findOrFail($id);
        $talk->update(['public' => $request->input('public') == 1]);

        TalkRevision::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'length' => $request->input('length'),
            'level' => $request->input('level'),
            'description' => $request->input('description'),
            'slides' => $request->input('slides'),
            'organizer_notes' => $request->input('organizer_notes'),
            'talk_id' => $talk->id,
        ]);

        Session::flash('success-message', 'Successfully edited talk.');

        return redirect("/talks/{$talk->id}");
    }

    public function destroy($id): RedirectResponse
    {
        auth()->user()->talks()->withoutGlobalScope('active')->findOrFail($id)->delete();

        Session::flash('success-message', 'Successfully deleted talk.');

        return redirect('talks');
    }

    public function archiveIndex(Request $request): View
    {
        $talks = $this->sortTalks(
            auth()->user()->archivedTalks()->withCurrentRevision()->get(),
            $request->input('sort')
        );

        return view('talks.archive', [
            'talks' => $talks,
            'sorted_by' => $this->sorted_by,
        ]);
    }

    public function archive($id): RedirectResponse
    {
        auth()->user()->talks()->findOrFail($id)->archive();

        Session::flash('success-message', 'Successfully archived talk.');

        return redirect('talks');
    }

    public function restore($id): RedirectResponse
    {
        auth()->user()->talks()->withoutGlobalScope('active')->findOrFail($id)->restore();

        Session::flash('success-message', 'Successfully restored talk.');

        return redirect('archive');
    }

    private function filterTalks($filter)
    {
        switch ($filter) {
            case 'submitted':
                return auth()->user()->talks()->withCurrentRevision()->submitted()->get();
                break;
            case 'accepted':
                return auth()->user()->talks()->withCurrentRevision()->accepted()->get();
                break;
            default:
                return auth()->user()->talks()->withCurrentRevision()->get();
                break;
        }
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
                    return strtolower($talk->currentRevision->title);
                });
                break;
        }
    }
}
