<li>
    <h3><a href="{{ route('conferences.show', ['id' => $conferenceSubmissionGroup[0]->conference->id]) }}">{{ $conferenceSubmissionGroup[0]->conference->title }}</a></h3>
    <ul>
        @foreach ($conferenceSubmissionGroup as $submittedTalk)
            <li>
                <ul class="conference-talk-submission-sidebar">
                    <li>
                        @if($submittedTalk->isAccepted())
                            <span class="btn btn-xs btn-success">Accepted!</span>
                        @else
                            <span class="btn btn-xs btn-default">Pending</span>
                        @endif
                        <a href="{{ route('talks.show', ['id' => $submittedTalk->talkRevision->id]) }}">{{ $submittedTalk->talkRevision->title }}</a>
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>
</li>
