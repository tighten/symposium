<div class="form-group">
    {!! Form::label('title', '*Title', ['class' => 'control-label']) !!}
    {!! Form::text('title', $conference->title, ['class' => 'form-control']) !!}
</div>

<location-lookup>
    <div class="form-group" slot-scope="location">
        {!! Form::label('location', 'Location', ['class' => 'control-label']) !!}
        {!! Form::text('location', $conference->location, [
            'class' => 'form-control',
            '@input' => 'location.lookup',
            '@keydown.enter.prevent' => true,
        ]) !!}
    </div>
</location-lookup>

<div class="form-group">
    {!! Form::label('description', '*Description', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', $conference->description, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('url', '*URL', ['class' => 'control-label']) !!}
    {!! Form::text('url', $conference->url, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cfp_url', 'URL to CFP page', ['class' => 'control-label']) !!}
    {!! Form::text('cfp_url', $conference->cfp_url, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('starts_at', 'Conference Start Date', ['class' => 'control-label']) !!}
    {!! Form::input('date', 'starts_at', $conference->startsAtSet() ? $conference->starts_at->format('Y-m-d') : '', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('ends_at', 'Conference End Date', ['class' => 'control-label']) !!}
    {!! Form::input('date', 'ends_at', $conference->endsAtSet() ? $conference->ends_at->format('Y-m-d') : '', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cfp_starts_at', 'CFP Open Date', ['class' => 'control-label']) !!}
    {!! Form::input('date', 'cfp_starts_at', $conference->cfpStartsAtSet() ? $conference->cfp_starts_at->format('Y-m-d') : '', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cfp_ends_at', 'CFP Close Date', ['class' => 'control-label']) !!}
    {!! Form::input('date', 'cfp_ends_at', $conference->cfpEndsAtSet() ? $conference->cfp_ends_at->format('Y-m-d') : '', ['class' => 'form-control']) !!}
</div>
