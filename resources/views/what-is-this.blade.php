@extends('app', ['title' => 'What is this site?'])

@section('content')

<p class="mt-8 text-xl">Symposium is an <strong>under-development</strong> site for conference speakers and conference organizers. </p>

<x-panel class="mt-8">
    <h2 class="text-3xl text-indigo-800">Conference Speakers</h2>
    <p>Symposium helps conference speakers plan and manage talk abstracts, CFP submissions, bios, photos, and speaking schedule.</p>

    <x-slot name="body">
        <div class="bg-indigo-100 p-10 pt-4">
            <h3 class="mt-5 text-2xl text-indigo-800">Talks</h3>
            <p>Track all of your talks, each with one or more versions (e.g. "Professional" vs. "Amateur" for audience, or maybe "Lightning" vs. "Keynote" for length), and each version with a full revision history.</p>
            <p>Look at which version of each talk you submitted to each conference, and how many times each talk has been accepted and rejected.</p>

            <h3 class="mt-5 text-2xl text-indigo-800">Bios</h3>
            <p>Store and version multiple biographies for sending in with your talk submissions.</p>

            <h3 class="mt-5 text-2xl text-indigo-800">Photos</h3>
            <p>Store multiple revisions of your bio photos, ready to grab and upload with your talk submissions.</p>

            <h3 class="mt-5 text-2xl text-indigo-800">Conferences</h3>
            <p>Find which conferences you're interested in applying to speak at; favorite them, track them, and get reminders when their CFPs open and close.</p>
            <p>Track which conferences have accepted or rejected your talk submissions.</p>
        </div>
    </x-slot>
</x-panel>

<x-panel class="mt-8">
    <h2 class="text-3xl text-indigo-800">Conference Organizers</h2>
    <x-slot name="body">
        <div class="bg-indigo-100 p-10">
            <p>Symposium helps conference organizers receive submissions (by allowing speakers to submit to any conference powered by a CFP platform that's compatible with Symposium).</p>
        </div>
    </x-slot>
</x-panel>

@endsection
