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
    <div>
        {!! Form::label('email', 'Email Address', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        {!! Form::email('email', null, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
        ]) !!}
    </div>

    <div class="mt-8">
        {!! Form::label('password', 'Password (leave empty to keep the same)', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        {!! Form::password('password', [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
        ]) !!}
    </div>

    <div class="mt-8">
        {!! Form::label('name', 'Name', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        {!! Form::text('name', null, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
        ]) !!}
    </div>

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

    <div class="mt-8">
        {!! Form::label('profile_slug', 'Profile URL slug', [
            'class' => 'block text-indigo-500 font-bold mb-2'
        ]) !!}
        <span class="help-block">The URL slug to be used for your public speaker profile. This will make your profile available at {{ route('speakers-public.show', 'your_slug_here') }}</span>
        {!! Form::text('profile_slug', null, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
        ]) !!}
    </div>

    <div class="mt-8">
        {!! Form::label('profile_intro', 'Profile Intro', [
            'class' => 'block text-indigo-500 font-bold'
        ]) !!}
        <span class="help-block">This paragraph will go at the top of your public speaker profile page. You can use it to communicate any message you'd like to conference organizers.</span>
        {!! Form::textarea('profile_intro', null, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
        ]) !!}
    </div>

    <div class="mt-8">
        {!! Form::label('location', 'Location', [
            'class' => 'block text-indigo-500 font-bold'
        ]) !!}
        <span class="help-block">Enter the city in which you reside and local conference organizers can find you.</span>
        {!! Form::text('location', null, [
            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
            'id' => 'autocomplete',
        ]) !!}
    </div>

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
