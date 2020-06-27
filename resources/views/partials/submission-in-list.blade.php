<li>
    <h3><a href="{{ route('conferences.show', [$conferenceSubmissionGroup->first()->conference_id]) }}">{{ $conferenceSubmissionGroup->first()->conference->title }}</a></h3>
    <ul>
        @foreach ($conferenceSubmissionGroup as $submittedTalk)
            <li>
                <ul class="conference-talk-submission-sidebar">
                    <li>
                        @if ($submittedTalk->isAccepted())
                            <span class="label label-xs label-success">Accepted!</span>
                        @else
                            <span class="label label-xs label-default">Pending</span>
                        @endif
                        <a href="{{ route('talks.show', [$submittedTalk, 'revision' => $submittedTalk->talkRevision->id]) }}">{{ $submittedTalk->talkRevision->title }}</a>
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>
</li>
