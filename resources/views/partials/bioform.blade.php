<div class="form-group">
    {{ Form::label('nickname', '*Nickname', ['class' => 'control-label']) }}
    {{ Form::text('nickname', $bio->nickname, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('body', '*Body', ['class' => 'control-label']) }}
    {{ Form::textarea('body', $bio->body, ['class' => 'form-control']) }}
</div>
