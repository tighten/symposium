@props([
    'submission',
])

<x-modal heading="Add Talk Reaction">
    <x-form :action="route('submissions.reactions.store', $submission)">
        <x-input.text name="url" label="URL"/>
        <x-button.primary type="submit" class="mt-8">
            Save
        </x-button.primary>
    </x-form>
</x-modal>
