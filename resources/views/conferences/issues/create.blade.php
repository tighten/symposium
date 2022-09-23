@extends('app')

@section('content')

<x-form :action="route('conferences.issues.store', $conference)">
    <x-panel :title='"Report an issue for {$conference->title}"'>
        <x-input.select
            name="reason"
            label="Reason"
            :options="$reasonOptions"
            option-text="text"
            option-value="value"
            :include-empty="true"
        ></x-input.select>

        <x-input.textarea
            name="note"
            label="Notes"
            class="mt-8"
        ></x-input.textarea>

    </x-panel>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Report Issue
    </x-button.primary>
</x-form>

@endsection
