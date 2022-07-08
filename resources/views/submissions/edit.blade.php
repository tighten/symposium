@extends('layouts.index', ['title' => "Edit Submission for {$conference->title}"])

@section('sidebar')
    <x-side-menu title="Reactions">
        <x-slot:body>
            @foreach ($submission->reactions as $reaction)
                <a
                    href="{{ $reaction->url }}"
                    class="py-1 px-5 hover:bg-indigo-100"
                    target="_blank"
                >
                    {{ $reaction->url }}
                </a>
            @endforeach
        </x-slot:body>
    </x-side-menu>
@endsection

@section('actions')
    <x-modal.add-talk-reaction :submission="$submission"/>
@endsection

@section('list')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('submission.update', $submission->id)" method="PUT">
    <x-input.radios
        name="response"
        label="*Submission Response"
        :value="$submission->response"
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
        :value="$submission->response_reason"
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

@endsection
