<div class="form-group">
    {!! Form::label('nickname', '*Nickname for this talk version', ['class' => 'control-label']) !!}
    {!! Form::text('nickname', $version->nickname, ['class' => 'form-control']) !!}

    <span class="help-block">Each version of each talk has a nickname to distinguish it from the other versions. Something like "Extended Workshop" or "Business Owners version".</span>
</div>
