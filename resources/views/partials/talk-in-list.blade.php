<li>
  <div class="pull-right">
  <a href="{{ route('talks.edit', ['id' => $talk->id]) }}" class="btn btn-xs btn-primary">
      <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
      Edit
  </a>
    <a href="{{ route('talks.delete', ['id' => $talk->id]) }}" class="btn btn-xs btn-danger">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        Delete
    </a>
    @if ($talk->isArchived())
        <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="btn btn-xs btn-warning">
            <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
            Restore
        </a>
    @else
        <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="btn btn-xs btn-warning">
            <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
            Archive
        </a>
    @endif


</div>
<h3><a href="{{ route('talks.show', ['id' => $talk->id]) }}">{{ $talk->current()->title }}</a></h3>
<p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString() }}</i> |
    {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}
</p>
</li>
