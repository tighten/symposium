@if (! isset($hideVersion) || ! $hideVersion)
<div class="form-group">
    {{ Form::label('nickname', 'Nickname for this talk version', ['class' => 'control-label']) }}
    {{ Form::text('nickname', $version->nickname, ['class' => 'form-control']) }}

    <span class="help-block">Each version of each talk has a nickname to distinguish it from the other versions. Something like "Extended Workshop" or "Business Owners version".</span>
</div>
@endif

<hr>

<div class="form-group">
    {{ Form::label('title', '*Talk Title', ['class' => 'control-label']) }}
    {{ Form::text('title', $current->title, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('type', 'Type of Talk', ['class' => 'control-label']) }}<br>
    <label class="radio-inline">
        {{ Form::radio('type', 'lightning', $current->type == 'lightning'); }} Lightning
    </label>
    <label class="radio-inline">
        {{ Form::radio('type', 'seminar', $current->type == 'seminar'); }} Seminar
    </label>
    <label class="radio-inline">
        {{ Form::radio('type', 'keynote', $current->type == 'keynote'); }} Keynote
    </label>
    <label class="radio-inline">
        {{ Form::radio('type', 'workshop', $current->type == 'workshop'); }} Workshop
    </label>
</div>

<div class="form-group">
    {{ Form::label('level', 'Difficulty Level', ['class' => 'control-label']) }}<br>
    <label class="radio-inline">
        {{ Form::radio('level', 'beginner', $current->level == 'beginner'); }} Beginner
    </label>
    <label class="radio-inline">
        {{ Form::radio('level', 'intermediate', $current->level == 'intermediate'); }} Intermediate
    </label>
    <label class="radio-inline">
        {{ Form::radio('level', 'advanced', $current->level == 'advanced'); }} Advanced
    </label>
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
    {{ Form::label('outline', 'Outline', ['class' => 'control-label']) }}
    {{ Form::textarea('outline', $current->outline, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('organizer_notes', 'Organizer Notes', ['class' => 'control-label']) }}
    {{ Form::textarea('organizer_notes', $current->organizer_notes, ['class' => 'form-control']) }}
</div>
