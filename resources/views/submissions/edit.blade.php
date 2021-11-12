@extends('layouts.index', ['title' => 'Edit Submission'])

@section('sidebar')
    <x-panel>
        <x-slot name="title">
            {{ $conference->title }}
            @if (! $conference->is_approved)
                <span style="color: red;">[NOT APPROVED]</span>
            @endif
        </x-slot>

        <x-slot name="actions">
            <div class="text-lg text-indigo-800">
                @if ($conference->author_id == auth()->user()->id || auth()->user()->isAdmin())
                    <a href="{{ route('conferences.edit', $conference) }}" title="Edit">
                        @svg('compose', 'w-5 fill-current inline')
                    </a>
                    <a href="{{ route('conferences.delete', ['id' => $conference->id]) }}" class="ml-3" title="Delete">
                        @svg('trash', 'w-5 fill-current inline')
                    </a>
                @endif
            </div>
        </x-slot>

        <div class="font-sans">
            @unless (empty($conference->location))
                <div class="text-gray-500">Location:</div>
                {{ $conference->location }}
            @endunless

            <div class="mt-4 text-gray-500">URL:</div>
            <a
                href="{{ $conference->url }}"
                class="hover:text-indigo-500"
            >
                {{ $conference->url }}
            </a>

            @if ($conference->cfp_url)
                <div class="mt-4 text-gray-500">URL for CFP page:</div>
                <a
                    href="{{ $conference->cfp_url }}"
                    class="hover:text-indigo-500"
                >
                    {{ $conference->cfp_url }}
                </a>
            @endif

            <div class="mt-4 text-gray-500">Description:</div>
            <!-- TODO: Figure out how we will be handling HTML/etc. -->
            {!! str_replace("\n", "<br>", $conference->description) !!}</p>
        </div>

        <x-slot name="footer">
            <div>
                <div class="mb-3">
                    <div class="text-gray-500">Dates</div>
                    <div>{{ $conference->startsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->endsAtDisplay() }}</div>
                </div>
                @if ($conference->cfp_starts_at && $conference->cfp_ends_at)
                    <div class="mb-3">
                        <div class="text-gray-500">CFP</div>
                        <div>{{ $conference->cfpStartsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->cfpEndsAtDisplay() }}</div>
                    </div>
                @endif
                <div class="mb-3">
                    <div class="text-gray-500">Created</div>
                    <div>{{ $conference->created_at->toFormattedDateString() }}</div>
                </div>
            </div>
        </x-slot>
    </x-panel>
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
            value="response"
            :options="[
                'Accepted' => 'acceptance',
                'Rejected' => 'rejection',
            ]"
            class="mt-8"
        ></x-input.radios>

        <x-input.text
            name="reason"
            label="Reason"
            type="text"
            placeholder=""
            autofocus="autofocus"
            maxlength="255"
            class="mt-8"
        ></x-input.text>

        <x-button.primary
            type="submit"
            size="md"
            class="mt-8"
        >
            Update
        </x-button.primary>
    </x-form>
@endsection
