<div class="form-group">
    {!! Form::label('nickname', '*Nickname', ['class' => 'control-label']) !!}
    {!! Form::text('nickname', $bio->nickname, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('body', '*Body', ['class' => 'control-label']) !!}
    {!! Form::textarea('body', $bio->body, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('public', '*Show on public speaker profile?', ['class' => 'control-label']) !!}
    <div class="input-group">
        <label class="radio-inline">
            <input type="radio" name="public" value="yes" {{ $bio->public ? 'checked' : ''}}>
            Yes
        </label>
        <label class="radio-inline">
            <input type="radio" name="public" value="no" {{ $bio->public ? '' : 'checked' }}>
            No
        </label>
    </div>
</div>
