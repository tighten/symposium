@extends('layout')

@section('content')
    <script>
        Symposium.talks = {!! json_encode($talks) !!};
    </script>
    <div class="container body">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $conference->title }}
                    @if (! $conference->is_approved)
                    <span style="color: red;">[NOT APPROVED]</span>
                    @endif
                </h1>

                <p class="pull-right action-buttons">
                @if ($conference->author_id == Auth::user()->id || auth()->user()->isAdmin())
                        <a href="{{ route('conferences.edit', ['id' => $conference->id]) }}" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        <a href="{{ route('conferences.delete', ['id' => $conference->id]) }}" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                @endif
                </p>

                <p><b>Date created:</b>
                    {{ $conference->created_at->toFormattedDateString() }}</p>

                <p><b>URL:</b>
                    <a href="{{ $conference->url }}">{{ $conference->url }}</a></p>

                @if ($conference->cfp_url)
                    <p><b>URL for CFP page:</b>
                        <a href="{{ $conference->cfp_url }}">{{ $conference->cfp_url }}</a></p>
                @endif

                <p><b>Description:</b><br>
                    <!-- TODO: Figure out how we will be handling HTML/etc. -->
                    {!! str_replace("\n", "<br>", $conference->description) !!}</p>

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
                    <div class="col-md-6" id="talks-on-conference-page">
                        <talks-on-conference-page conference-id="{{ $conference->id }}"></talks-on-conference-page>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
