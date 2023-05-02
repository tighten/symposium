@extends('app', ['title' => 'Conferences'])

@section('content')
    <div>
        <livewire:conference-list/>
    </div>

    @if (auth()->user())
        <div class="mt-4 text-right">
            <x-button.primary
                :href="route('conferences.create')"
                icon="plus"
            >
                Suggest a Missing Conference
            </x-button.primary>
        </div>
    @endif
@endsection
