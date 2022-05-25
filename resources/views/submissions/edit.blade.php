@extends('app', ['title' => "Edit Submission for {$conference->title}"])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('submission.update', $submission->id)" method="PUT">
    <x-input.radios
        name="response"
        label="*Submission Response"
        value="response"
        :options="[
            'Accepted' => 'acceptance',
            'Rejected' => 'rejection',
        ]"
        class="mt-8"
    ></x-input.radios>

    <x-input.textarea
        name="reason"
        label="Reason"
        type="text"
        placeholder=""
        autofocus="autofocus"
        maxlength="255"
        class="mt-8"
    ></x-input.textarea>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Update
    </x-button.primary>
</x-form>

<x-modal.add-talk-reaction :submission="$submission"/>

@endsection
