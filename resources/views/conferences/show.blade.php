@extends('layout')

@section('content')
    <script>
        Symposium.talks = {{ json_encode($talks->map(function ($talk) use ($talksAtConference) {
            return [
                'id' => $talk->id,
                'title' => $talk->current()->title,
                'url' => $talk->current()->getUrl(),
                'atThisConference' => $talksAtConference->search($talk->id) !== false,
            ];
        })) }};
    </script>
    <div class="container body">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $conference->title }}</h1>

                @if ($conference->author_id == Auth::user()->id)
                    <p class="pull-right">
                        <a href="{{ route('conferences.edit', ['id' => $conference->id]) }}" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        <a href="{{ route('conferences.delete', ['id' => $conference->id]) }}" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </p>
                @endif

                <p><b>Date created:</b>
                    {{ $conference->created_at->toFormattedDateString() }}</p>

                <p><b>URL:</b>
                    <a href="{{ $conference->url }}">{{ $conference->url }}</a></p>

                <p><b>Description:</b><br>
                    <!-- TODO: Figure out how we will be handling HTML/etc. -->
                    {{ str_replace("\n", "<br>", $conference->description) }}</p>

                @if ($conference->joindin_id)
                    <p><b>JoindIn ID:</b>
                        <a href="http://joind.in/event/view/{{ $conference->joindin_id }}">{{ $conference->joindin_id }}</a></p> </p>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <p><b>Date conference starts:</b>
                            {{ $conference->startsAtDisplay() }}</p>

                        <p><b>Date conference ends:</b>
                            {{ $conference->endsAtDisplay() }}</p>

                        <p><b>Date CFP opens:</b>
                            {{ $conference->cfpStartsAtDisplay() }}</p>

                        <p><b>Date CFP closes:</b>
                            {{ $conference->cfpEndsAtDisplay() }}</p>
                    </div>
                    <div class="col-md-6">
                        <div id="talks-on-conference-page" conference-id="{{ $conference->id }}">
                            <h3>My Talks</h3>
                            <p><i>Note: "Submit" just means "mark as submitted." At the moment this isn't actually sending anything to the conference organizers.</i></p>
                            <strong>Applied to speak at this conference</strong>
                            <ul class="conference-talk-submission-sidebar">
                                <li v-for="talk in talksAtConference" v-cloak>
                                    <a class="btn btn-xs btn-default" @click.prevent="unsubmit(talk)">
                                        <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                                        Un-Submit
                                    </a>
                                    <a href="@{{ talk.url }}">@{{ talk.title }}</a>
                                    <?php /* |  <a href="#" onclick="alert('Not programmed yet');">Change status [accepted, rejected, submitted]</a> */ ?>
                                </li>
                                <li v-if="talksAtConference.length == 0" v-cloak>
                                    None
                                </li>
                            </ul>

                            <strong>Not applied to speak at this conference</strong>
                            <ul class="conference-talk-submission-sidebar">
                                <li v-for="talk in talksNotAtConference" v-cloak>
                                    <a class="btn btn-xs btn-primary" @click.prevent="submit(talk)">
                                        <i v-show="talk.loading" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                                        Submit
                                    </a>
                                    <a href="@{{ talk.url }}">@{{ talk.title }}</a>
                                </li>
                                <li v-if="talksNotAtConference.length == 0" v-cloak>
                                    None
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
