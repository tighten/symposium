<div class="form-group">
    {{ Form::label('title', '*Talk Title', ['class' => 'control-label']) }}
    {{ Form::text('title', $current->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('type', '*Type of Talk', ['class' => 'control-label']) }}
    <select name="type" id="type" class="form-control">
        <option value="seminar" {{ $current->type == 'seminar' ? 'selected' : ''}}>
            Seminar
        </option>
        <option value="workshop" {{ $current->type == 'workshop' ? 'selected' : ''}}>
            Workshop
        </option>
        <option value="lightning" {{ $current->type == 'lightning' ? 'selected' : ''}}>
            Lightning
        </option>
        <option value="keynote" {{ $current->type == 'keynote' ? 'selected' : ''}}>
            Keynote
        </option>
    </select>
</div>

<div class="form-group">
    {{ Form::label('level', '*Difficulty Level', ['class' => 'control-label']) }}
    <select class="form-control" name="level" id="level">
        <option value="beginner" {{ $current->level == 'beginner' ? 'selected' : '' }}>
            Beginner
        </option>
        <option value="intermediate" {{ $current->level == 'intermediate' ? 'selected' : '' }}>
            Intermediate
        </option>
        <option value="advanced" {{ $current->level == 'advanced' ? 'selected' : '' }}>
            Advanced
        </option>
    </select>
</div>

<div class="form-group">
    {{ Form::label('length', '*Length', ['class' => 'control-label']) }}
    <div class="input-group">
        {{ Form::text('length', $current->length, ['class' => 'form-control']) }}
        <div class="input-group-addon">mins</div>
    </div>
</div>

<div class="form-group">
    {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
    {{ Form::textarea('description', $current->description, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('organizer_notes', 'Organizer Notes', ['class' => 'control-label']) }}
    {{ Form::textarea('organizer_notes', $current->organizer_notes, ['class' => 'form-control']) }}
</div>
