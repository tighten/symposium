@extends('layout')

@section('content')

<div class="bg-white py-10 px-10 lg:px-56 mt-8">
    <h2 class="text-4xl mt-8">Are you sure?</h2>

    <p class="mt-8">Are you sure you want to delete your account?</p>

    <x-form :action="route('account.delete.confirm')">
        <div class="flex mt-8">
            <x-button.primary
                type="submit"
                size="md"
            >
                Yes
            </x-button.primary>
            <x-button.secondary
                :href="route('account.show')"
                size="md"
                class="ml-8"
            >
                No
            </x-button.secondary>
        </div>
    </x-form>
</div>

@endsection
