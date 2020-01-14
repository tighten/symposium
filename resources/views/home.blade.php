@extends('layout')

@section('content')
    <div class="flex flex-col items-center justify-around max-w-md md:flex-row md:py-12 mx-auto pb-6 pt-0 px-8 sm:max-w-6xl">
        <div class="flex flex-col">
            <h1 class="font-sans lg:text-7xl md:text-5xl text-5xl text-black">Connecting<br>Speakers<br>&amp; Conferences</h1>
            <div class="flex flex-col lg:flex-row lg:text-lg md:text-base mt-12 sm:text-lg text-base text-sans text-semibold xl:text-xl">
                <a class="bg-indigo block lg:px-10 lg:py-5 md:inline-block md:px-8 md:py-4 md:text-left px-4 py-2 rounded-lg text-center text-white whitespace-no-wrap " href="#">Sign up for <span class="uppercase">free</span></a> <a class=" block border border-indigo lg:ml-10 lg:mt-0 lg:px-10 lg:py-5 md:inline-block md:px-8 md:py-4 md:text-left mt-4 mt-4 px-4 py-2 rounded rounded-lg text-center text-indigo whitespace-no-wrap" href="https://www.youtube.com/watch?v=60hxVJpEXhw" target="_blank">
                    @svg('rectangle', 'inline mr-3 mt-2')
                    Watch Demo
                </a>
            </div>
        </div>

        @svg('home', 'max-w-md md:order-first sm:pr-4')
    </div>

    <div class="bg-indigo-100 relative">
        <div class="py-12 max-w-md mx-auto sm:max-w-6xl pb-40 px-1">
            <div class="flex flex-col items-center mx-auto mb-16">
                @svg('podium', 'mw-24')
                <h2 class="text-center text-indigo font-sans text-5xl">Conference Speakers</h2>
                <div class="text-center font-sans text-3xl max-w-2xl">Symposium helps conference speakers plan and manage talk abstracts, CFP submissions, bios, photos, and speaking schedule.</div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 lg:pl-0 pb-6 md:pb-0">
                    @svg('icon_tracktalks', 'mx-auto md:ml-3 w-16 h-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Track talks</div>
                    <div class="font-sans text-xl">Track all of your talks, each with one or more versions and each version with a full revision history.</div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 pb-6 md:pb-0">
                    @svg('icon_versioncontrol', 'mx-auto md:ml-3 w-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Talk version control</div>
                    <div class="font-sans text-xl">Look at which of each talk you submitted to each conference, and how many times each talk has been accepted and rejected.</div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 lg:pr-0 pb-6 md:pb-0">
                    @svg('icon_trackconferences', 'mx-auto md:ml-3 w-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Track conferences</div>
                    <div class="font-sans text-xl">Track which conferences have accepted or rejected your talk submissions.</div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 lg:pl-0 pb-6 md:pb-0">
                    @svg('icon_find', 'mx-auto md:ml-3 w-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Find conferences</div>
                    <div class="font-sans text-xl">Find which conferences you're interested in applying to speak at; favorite them, track them, and get reminders when their CFP's open and close.</div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 pb-6 md:pb-0">
                    @svg('icon_bios', 'mx-auto md:ml-3 w-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Bios</div>
                    <div class="font-sans text-xl">Store and version multiple biographies for sending in with your talk submissions.</div>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 mb-8 px-6 lg:pr-0 pb-6 md:pb-0">
                    @svg('icon_photos', 'mx-auto md:ml-3 w-16')
                    <div class="text-center md:text-left font-sans text-2xl mt-5 font-semibold mb-4">Photos</div>
                    <div class="font-sans text-xl">Store multiple revisions of your bio photos, ready to grab snd upload with your talk submissions.</div>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-indigo-500 pb-24">
        <div class="bg-white relative rounded-lg shadow px-8 py-12 max-w-md mx-auto sm:max-w-6xl -mt-20">
            <div class="flex flex-col items-center mb-56">
                @svg('badge')
                <h2 class="text-indigo font-sans text-5xl mb-12">Conference Organizers</h2>
                <div class="text-center max-w-3xl mx-auto font-sans text-3xl">Symposium helps conference organizers receive submissions by allowing speakers to submit to any conference powered by a CFP platform that's compatible with Symposium-right now we're working toward an OpenCFP integration.</div>
            </div>
        </div>
        <div class="max-w-md mx-auto sm:max-w-6xl mt-20">
            <h2 class="text-white text-center font-sans text-5xl">Our Speakers</h2>
            <div class="flex justify-between mt-16">
                @foreach ($speakers as $speaker)
                    <div class="flex flex-col items-center">
                        <img
                            class="rounded-full w-32 h-32"
                            style="filter:grayscale(100%);"
                            src="{{ $speaker->profile_picture_hires }}"
                            alt="{{ $speaker->name }} profile picture"
                        >
                        <div class="p-8 text-white text-center">{{ $speaker->name }}</div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-20">
                <a class="text-white border rounded px-8 py-6 font-sans font-semibold text-xl" href="#">View all speakers</a>
            </div>
        </div>
    </div>

    <div class="bg-indigo-800">
        <div class="flex flex-col px-8 py-32 max-w-md mx-auto sm:max-w-6xl">
            <h2 class="text-white text-center font-sans text-5xl">Conferences</h2>
            <div class="flex justify-between mt-20 mb-16">
                @foreach ($conferences as $conference)
                    <div class="w-1/3 bg-white rounded-lg first:mr-8 last:ml-8 px-8 pt-12 pb-24 font-sans relative shadow">
                        <div class="text-center text-2xl text-indigo-800 mb-24">{{ $conference->title }}</div>
                        <div class="font-medium text-xl">{{ $conference->event_dates_display }}</div>
                        <div class="mt-6 text-xl">{{ $conference->description }}</div>
                        <div class="block my-10 bottom-0 absolute">
                            <a class="text-xl font-semibold text-indigo-800" href="#">More Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-16">
                <a class="text-white border rounded px-10 py-6 font-sans font-semibold text-xl" href="#">View all conferences</a>
            </div>
        </div>
    </div>

    <div class="bg-black">
        <div class="flex flex-col py-32 max-w-md mx-auto sm:max-w-6xl">
            <h2 class="text-white text-center font-sans text-5xl">Ready to get started?</h2>
            <div class="flex font-sans text-xl mt-20">
                <input class="w-1/4 rounded mr-8 px-5 py-6" name="name" placeholder="Name">
                <input class="w-1/4 rounded mr-8 px-5 py-6" name="email" placeholder="Email">
                <input class="w-1/4 rounded mr-8 px-5 py-6" name="password" placeholder="Password">
                <input type="submit" class="w-1/4 rounded bg-indigo-800 text-white border-none" value="Sign up">
            </div>
        </div>
    </div>

            {{-- <div class="row">
                <div class="col-md-8">
                    <p>Symposium is a single place for <strong>speakers</strong> to manage talk proposals, bios, photos, and conference applications and responses.</p>

                    <p>
                        <a href="https://www.youtube.com/watch?v=60hxVJpEXhw" target="_blank">
                            <img src="{{ url('/img/symposium-screenshot.png') }}" alt="Symposium Screenshot" style="border-radius: 0.5em">
                        </a>
                    </p>

                    <p>Symposium <b>will be</b> a single place for <strong>conference organizers</strong> to open CFPs, review speakers submissions, and manage the entire CFP process.</p>
                </div>
                <div class="col-md-4">
                    {{-- Disable email registration --}}
                    {{-- @if (false && Auth::guest())
                        <div class="panel panel-default panel-on-grey">
                            <div class="panel-heading">
                              <h3 class="panel-title">Sign up</h3>
                            </div>
                            <div class="panel-body">
                                @include('partials.sign-up-form')
                            </div>
                        </div>
                    @endif

                    <div class="panel panel-default panel-on-grey">
                        <div class="panel-heading">
                            @if (Auth::guest())
                                <h3 class="panel-title">Log in</h3>
                            @endif
                        </div>
                        <div class="panel-body">
                            @if (Auth::guest())
                                <div class="text-center">
                                    <a class="btn-github-login" href="{{ url('login/github') }}">Log in with <strong>GitHub</strong> @svg('github', 'inline-block align-top h-6 w-6')</a>
                                    <p class="text-gray-400 text-base">or</p>
                                </div>
                                @include('partials.log-in-form')
                            @else
                                <p><a href="{{ route('dashboard') }}">Dashboard</a> | <a href="{{ route('log-out') }}">Logout</a></p>

                                <hr>

                                <div class="pronto-promo">
                                    <a href="http://rdohms.github.io/pronto/">
                                        <img src="{{ url('/img/pronto-logo.png') }}">
                                    </a>
                                    <p>Did you know you can use <a href="http://rdohms.github.io/pronto/">Pronto!</a> to easily submit your Symposium talks to conference web sites?</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> --}}
        {{-- </div>
    </div> --}}

    <!--<a href="/im-a-bot">I'm a bot</a>-->
@stop
