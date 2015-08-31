<h3><a href="{{ route('bios.show', ['id' => $bio->id]) }}">{{ $bio->nickname }}</a></h3>
<p>{{ $bio->preview }}</p>
<p>
    <a  class="btn btn-xs btn-danger" href="{{ route('bios.delete', ['id' => $bio->id]) }}" data-confirm="Are you sure you want to delete this bio?">
        Delete
    </a>
    <a class="btn btn-xs btn-default" href="{{ route('bios.edit', ['id' => $bio->id]) }}">
        Edit
    </a>
    <button type="button" class="btn btn-xs btn-default" data-clipboard data-clipboard-text="{{ $bio->body }}">
        <span class="octicon octicon-clippy"></span> Copy
    </button>
</p>
