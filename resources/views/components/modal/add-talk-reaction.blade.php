@props([
    'submission',
])

<x-modal heading="Add Talk Reaction">
    <x-slot:trigger>
        <x-button.primary
            icon="plus"
            class="block w-full"
            @click="toggleModal"
        >
            Add Talk Reaction
        </x-button.primary>
    </x-slot:trigger>
    <x-form :action="route('submissions.reactions.store', $submission)">
        <x-input.text name="url" label="URL"/>
        <x-button.primary type="submit" class="mt-8">
            Save
        </x-button.primary>
    </x-form>
</x-modal>
