<div class="pull-right">
	<a href="/talks/{{ $talk->id }}/edit" class="btn btn-sm btn-primary">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
	<a href="/talks/{{ $talk->id }}/delete" class="btn btn-sm btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
</div>
<h3><a href="{{ route('talks.show', ['id' => $talk->id]) }}">{{ $talk->current()->title }}</a></h3>
<p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString()  }}</i> | {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</p>
