<x-input.text
    name="title"
    label="*Title"
    :value="$conference->title"
></x-input.text>

<location-lookup class="mt-8">
    <template slot-scope="location">
        <x-input.text
            name="location"
            label="Location"
            :value="$conference->location"
            @input="location.lookup"
            @keydown.enter.prevent="true"
        ></x-input.text>
    </template>
</location-lookup>

<div class="mt-8">
    {!! Form::label('description', '*Description', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::textarea('description', $conference->description, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<x-input.text
    name="url"
    label="*URL"
    :value="$conference->url"
    class="mt-8"
></x-input.text>

<x-input.text
    name="cfp_url"
    label="URL to CFP page"
    :value="$conference->cfp_url"
    class="mt-8"
></x-input.text>

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
