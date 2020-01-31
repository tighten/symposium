<div>
    {!! Form::label('title', '*Title', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::text('title', $conference->title, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<location-lookup class="mt-8">
    <div class="form-group" slot-scope="location">
        {!! Form::label('location', 'Location', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        {!! Form::text('location', $conference->location, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
            '@input' => 'location.lookup',
            '@keydown.enter.prevent' => true,
        ]) !!}
    </div>
</location-lookup>

<div class="mt-8">
    {!! Form::label('description', '*Description', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::textarea('description', $conference->description, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('url', '*URL', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::text('url', $conference->url, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('cfp_url', 'URL to CFP page', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::text('cfp_url', $conference->cfp_url, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('starts_at', 'Conference Start Date', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::input('date', 'starts_at', $conference->startsAtSet() ? $conference->starts_at->format('Y-m-d') : '', [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('ends_at', 'Conference End Date', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::input('date', 'ends_at', $conference->endsAtSet() ? $conference->ends_at->format('Y-m-d') : '', [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('cfp_starts_at', 'CFP Open Date', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::input('date', 'cfp_starts_at', $conference->cfpStartsAtSet() ? $conference->cfp_starts_at->format('Y-m-d') : '', [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('cfp_ends_at', 'CFP Close Date', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::input('date', 'cfp_ends_at', $conference->cfpEndsAtSet() ? $conference->cfp_ends_at->format('Y-m-d') : '', [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>
