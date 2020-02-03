<div>
    {!! Form::label('nickname', '*Nickname', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::text('nickname', $bio->nickname, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('body', '*Body', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    {!! Form::textarea('body', $bio->body, [
        'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
    ]) !!}
</div>

<div class="mt-8">
    {!! Form::label('public', '*Show on public speaker profile?', [
        'class' => 'block text-indigo-500 font-bold mb-2'
    ]) !!}
    <label class="inline-flex items-center">
        <input
            type="radio"
            class="form-radio"
            name="public"
            value="yes"
            {{ $bio->public ? 'checked' : '' }}
        >
        <span class="ml-2">Yes</span>
    </label>
    <label class="inline-flex items-center ml-6">
        <input
            type="radio"
            class="form-radio"
            name="public"
            value="no"
            {{ $bio->public ? '' : 'checked' }}
        >
        <span class="ml-2">No</span>
    </label>
</div>
