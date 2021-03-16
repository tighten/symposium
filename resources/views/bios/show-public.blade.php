@extends('app')

@section('content')

<x-panel>
    <x-button.primary
        :href="route('speakers-public.show', $user->profile_slug)"
        icon="arrow-thick-left"
        class="inline-block"
    >
        Return to profile for {{ $user->name }}
    </x-button.primary>

    <h2 class="text-4xl mt-8">{{ $bio->nickname }}</h2>

    {!! str_replace("\n", "<br>", $bio->body) !!}
</x-panel>

@endsection
