@extends('layout', ['title' => 'Edit Account'])

@section('content')

<div class="px-10 py-3 max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 bg-white rounded mt-4 mb-20">

    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    {!! Form::model($user, [
        'route' => 'account.edit',
        'method' => 'put',
        'files' => 'true'
    ]) !!}

    <h3 class="font-sans mb-8">User</h3>

    <x-input.text
        name="email"
        label="Email Address"
        type="email"
        :value="$user->email"
    ></x-input.text>

    <x-input.text
        name="password"
        label="Password (leave empty to keep the same)"
        type="password"
        class="mt-8"
    ></x-input.text>

    <x-input.text
        name="name"
        label="Name"
        class="mt-8"
        :value="$user->name"
    ></x-input.text>

    <div class="mt-8">
        {!! Form::label('profile_picture', 'Profile Picture', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        <div class="private-profile-pic">
            <img src="{{ Auth::user()->profile_picture_hires }}" class="public-speaker-picture" alt="">
        </div>
        @if ($user->profile_picture == null)
            <div class="alert alert-warning">
                <strong>Your current public profile picture is sourced from Gravatar.</strong><br>
                Please upload a custom profile picture.
            </div>
        @endif
        <span class="help-block">Please use a high resolution image, as it will be provided to conference organizers.</span>
        {!! Form::file('profile_picture', null) !!}
    </div>

    <div class="mt-8">
        {!! Form::label('enable_profile', 'Enable email notifications?', [
            'class' => 'block text-indigo-500 font-bold'
        ]) !!}
        <span class="help-block">Do you want to receive email notifications for open CFPs?</span>
        <label class="inline-flex items-center">
            {!! Form::radio('wants_notifications', true, [
                'id' => 'wants_notifications_true',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">Yes</span>
        </label>
        <label class="inline-flex items-center ml-6">
            {!! Form::radio('wants_notifications', false, [
                'id' => 'wants_notifications_false',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">No</span>
        </label>
    </div>

    <hr class="my-8">

    <h3 class="font-sans mb-8">Public Profile</h3>

    <div class="mt-8">
        {!! Form::label('enable_profile', 'Show Public Speaker Profile?', [
            'class' => 'block text-indigo-500 font-bold'
        ]) !!}
        <span class="help-block">Do you want a public speaker page that you can show to conference organizers?</span>
        <label class="inline-flex items-center">
            {!! Form::radio('enable_profile', true, [
                'id' => 'enable_profile_true',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">Yes</span>
        </label>
        <label class="inline-flex items-center ml-6">
            {!! Form::radio('enable_profile', false, [
                'id' => 'enable_profile_false',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">No</span>
        </label>
    </div>

    <div class="mt-8">
        {!! Form::label('allow_profile_contact', 'Allow contact from your Public Speaker Profile?', [
            'class' => 'block text-indigo-500 font-bold'
        ]) !!}
        <span class="help-block">Do you want a contact form on your public speaker profile? Messages will be sent to your email but your email address will remain private.</span>
        <label class="inline-flex items-center">
            {!! Form::radio('allow_profile_contact', true, [
                'id' => 'allow_profile_contact_true',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">Yes</span>
        </label>
        <label class="inline-flex items-center ml-6">
            {!! Form::radio('allow_profile_contact', false, [
                'id' => 'allow_profile_contact_false',
                'class' => 'form-radio',
            ]) !!} <span class="ml-2">No</span>
        </label>
    </div>

    <x-input.text
        name="profile_slug"
        label="Profile URL slug"
        :value="$user->profile_slug"
        class="mt-8"
        help="The URL slug to be used for your public speaker profile. This will make your profile available at {{ route('speakers-public.show', 'your_slug_here') }}"
    ></x-input.text>

    <x-input.textarea
        name="profile_intro"
        label="Profile Intro"
        class="mt-8"
        help="This paragraph will go at the top of your public speaker profile page. You can use it to communicate any message you'd like to conference organizers."
        :value="$user->profile_intro"
    ></x-input.textarea>

    <x-input.text
        name="location"
        label="Location"
        class="mt-8"
        help="Enter the city in which you reside and local conference organizers can find you."
    ></x-input.text>

    <div class="mt-8">
        {!! Form::hidden('neighborhood', null, ['id' => 'neighborhood', 'readonly' => true]) !!}
        {!! Form::hidden('sublocality', null, ['id' => 'sublocality_level_1', 'readonly' => true]) !!}
        {!! Form::hidden('city', null, ['id' => 'locality', 'readonly' => true]) !!}
        {!! Form::hidden('state', null, ['id' => 'administrative_area_level_1', 'readonly' => true]) !!}
        {!! Form::hidden('country', null, ['id' => 'country', 'readonly' => true]) !!}
    </div>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Save
    </x-button.primary>

    {!! Form::close() !!}
</div>

@endsection

@push('scripts')
<script src="{{ elixir('js/location.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places&callback=initAutocomplete" async defer></script>
@endpush
