<div class="form-group">
    {!! Form::label('title', '*Talk Title', ['class' => 'control-label']) !!}
    {!! Form::text('title', $current->title, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('type', '*Type of Talk', ['class' => 'control-label']) !!}
    <div>
        <label class="radio-inline">
            <input type="radio" name="type" value="seminar" {{ $current->type == 'seminar' ? 'checked' : '' }}>
            Seminar
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" value="workshop" {{ $current->type == 'workshop' ? 'checked' : '' }}>
            Workshop
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" value="lightning" {{ $current->type == 'lightning' ? 'checked' : '' }}>
            Lightning
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" value="keynote" {{ $current->type == 'keynote' ? 'checked' : '' }}>
            Keynote
        </label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('level', '*Difficulty Level', ['class' => 'control-label']) !!}
    <div>
        <label class="radio-inline">
            <input type="radio" name="level" value="beginner" {{ $current->level == 'beginner' ? 'checked' : '' }}>
            Beginner
        </label>
        <label class="radio-inline">
            <input type="radio" name="level" value="intermediate" {{ $current->level == 'intermediate' ? 'checked' : '' }}>
            Intermediate
        </label>
        <label class="radio-inline">
            <input type="radio" name="level" value="advanced" {{ $current->level == 'advanced' ? 'checked' : '' }}>
            Advanced
        </label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('length', '*Length', ['class' => 'control-label']) !!}
    <div class="input-group">
        {!! Form::text('length', $current->length, ['class' => 'form-control']) !!}
        <div class="input-group-addon">mins</div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('public', '*Show on public speaker profile?', ['class' => 'control-label']) !!}
    <div class="input-group">
        <label class="radio-inline">
            <input type="radio" name="public" value="yes" {{ $talk->public ? 'checked' : '' }}>
            Yes
        </label>
        <label class="radio-inline">
            <input type="radio" name="public" value="no" {{ $talk->public ? '' : 'checked' }}>
            No
        </label>
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!} <span> (markdown supported)</span>
    {!! Form::textarea('description', $current->description, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('slides', 'Slides URL', ['class' => 'control-label']) !!}
    {!! Form::text('slides', $current->slides, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('organizer_notes', 'Organizer Notes', ['class' => 'control-label']) !!}
    {!! Form::textarea('organizer_notes', $current->organizer_notes, ['class' => 'form-control']) !!}
</div>
