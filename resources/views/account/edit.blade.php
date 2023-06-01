@extends('app', ['title' => 'Edit Account'])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('account.edit', $user)" method="PUT" :upload="true">
    <x-panel size="xl" title="User">
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
            <label for="profile_picture" class="block mb-2 font-extrabold text-indigo-900">
                Profile Picture
            </label>
            <div class="text-center rounded-full">
                <img
                    id="profile_picture"
                    src="{{ auth()->user()->profile_picture_hires }}"
                    class="w-48 h-48 mb-1 rounded-full"
                    alt="profile picture"
                >
            </div>
            @if ($user->profile_picture == null)
                <x-alert.warning>
                    <strong>Your current public profile picture is sourced from Gravatar.</strong><br>
                    Please upload a custom profile picture.
                </x-alert.warning>
            @endif
            <x-input.upload
                name="profile_picture"
                help="Please use a high resolution image, as it will be provided to conference organizers."
                class="mt-2"
            ></x-input.upload>
        </div>

        <x-input.radios
            name="wants_notifications"
            label="Enable email notifications?"
            :options="[
                'Yes' => '1',
                'No' => '0',
            ]"
            :value="$user->wants_notifications"
            help="Do you want to receive email notifications for open CFPs?"
            class="mt-8"
        ></x-input.radios>
    </x-panel>

    <x-panel size="xl" title="Public Profile" class="mt-6">
        <x-input.radios
            name="enable_profile"
            label="Show Public Speaker Profile?"
            :options="[
                'Yes' => '1',
                'No' => '0',
            ]"
            :value="$user->enable_profile"
            help="Do you want a public speaker page that you can show to conference organizers?"
        ></x-input.radios>

        <x-input.radios
            name="allow_profile_contact"
            label="Allow contact from your Public Speaker Profile?"
            :options="[
                'Yes' => '1',
                'No' => '0',
            ]"
            :value="$user->allow_profile_contact"
            help="Do you want a contact form on your public speaker profile? Messages will be sent to your email but your email address will remain private."
            class="mt-8"
        ></x-input.radios>

        <x-input.text
            name="profile_slug"
            label="Profile URL slug"
            :value="$user->profile_slug"
            help="The URL slug to be used for your public speaker profile. This will make your profile available at {{ route('speakers-public.show', 'your_slug_here') }}"
            class="mt-8"
        ></x-input.text>

        <x-input.textarea
            name="profile_intro"
            label="Profile Intro"
            :value="$user->profile_intro"
            help="This paragraph will go at the top of your public speaker profile page. You can use it to communicate any message you'd like to conference organizers."
            class="mt-8"
        ></x-input.textarea>

        <x-input.text
            name="location"
            label="Location"
            :value="$user->location"
            help="Enter the city in which you reside and local conference organizers can find you."
            class="mt-8"
        ></x-input.text>

        <input name="neighborhood" id="neighborhood" type="hidden" readonly>
        <input name="sublocality" id="sublocality_level_1" type="hidden" readonly>
        <input name="city" id="locality" type="hidden" readonly>
        <input name="state" id="administrative_area_level_1" type="hidden" readonly>
        <input name="country" id="country" type="hidden" readonly>

    </x-panel>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-6"
    >
        Save
    </x-button.primary>
</x-form>

@endsection
