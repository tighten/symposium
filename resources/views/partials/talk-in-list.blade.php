<div class="pull-right">
    <a href="{{ route('talks.delete', ['id' => $talk->id]) }}" class="btn btn-xs btn-danger">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        Delete
    </a>
    <a href="{{ route('talks.edit', ['id' => $talk->id]) }}" class="btn btn-xs btn-primary">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        Edit
    </a>
</div>
<h3><a href="{{ route('talks.show', ['id' => $talk->id]) }}">{{ $talk->current()->title }}</a></h3>
<p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString()  }}</i> | {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</p>
