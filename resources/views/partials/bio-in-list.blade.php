<li>
    <div class="pull-right">
        <a class="btn btn-xs btn-danger" href="{{ route('bios.delete', ['id' => $bio->id]) }}" data-confirm="Are you sure you want to delete this bio?">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            Delete
        </a>
        <a class="btn btn-xs btn-primary" href="{{ route('bios.edit', ['id' => $bio->id]) }}">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        </a>
        <button type="button" class="btn btn-xs btn-default" data-clipboard data-clipboard-text="{{ $bio->body }}">
            @svg('clipboard', 'fill-current inline-block align-text-bottom h-4 w-4') Copy
        </button>
    </div>

    <h3><a href="{{ route('bios.show', ['id' => $bio->id]) }}">{{ $bio->nickname }}</a></h3>
    <p>{{ $bio->preview }}</p>
</li>
