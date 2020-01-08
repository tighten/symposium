@extends('layout')

@section('content')
    <div class="flex justify-between items-center px-8 py-12 max-w-md mx-auto sm:max-w-6xl">
        @svg('home', 'max-w-md')
        <div class="flex flex-col">
            <h1 class="text-7xl font-sans text-gray-300">Connecting<br>Speakers<br>&amp; Conferences</h1>
            <div class="mt-12 text-sans text-semibold text-xl">
                <a class="bg-indigo text-white px-12 py-6 rounded" href="#">Sign up for <span class="uppercase">free</span></a>
                <a class="text-indigo border border-indigo rounded px-12 py-6 rounded ml-2" href="https://www.youtube.com/watch?v=60hxVJpEXhw" target="_blank">
                    @svg('rectangle', 'inline mr-3 -mt-2')
                    Watch Demo
                </a>
            </div>
        </div>
    </div>

    <div class="bg-indigo-100 relative">
        <div class="px-8 py-12 max-w-md mx-auto sm:max-w-4xl">
            <div class="flex flex-col items-center max-w-sm mx-auto mb-8">
                <h2 class="text-indigo">Conference Speakers</h2>
                <div class="text-center">Symposium helps conference speakers plan and manage talk abstracts, CFP submissions, bios, photos, and speaking schedule.</div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Track talks</div>
                    <div>Track all of your talks, each with one or more versions and each version with a full revision history.</div>
                </div>
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Talk version control</div>
                    <div>Look at which of each talk you submitted to each conference, and how many times each talk has been accepted and rejected.</div>
                </div>
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Track conferences</div>
                    <div>Track which conferences have accepted or rejected your talk submissions.</div>
                </div>
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Find conferences</div>
                    <div>Find which conferences you're interested in applying to speak at; favorite them, track them, and get reminders when their CFP's open and close.</div>
                </div>
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Bios</div>
                    <div>Store and version multiple biographies for sending in with your talk submissions.</div>
                </div>
                <div class="w-1/3 mb-8 p-4">
                    <div class="font-semibold mb-4">Photos</div>
                    <div>Store multiple revisions of your bio photos, ready to grab snd upload with your talk submissions.</div>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-indigo-500">
        <div class="bg-white relative rounded shadow px-8 py-12 max-w-md mx-auto sm:max-w-4xl -mt-8">
            <div class="flex flex-col items-center max-w-sm mx-auto mb-8">
                <h2 class="text-indigo">Conference Organizers</h2>
                <div class="text-center">Symposium helps conference organizers receive submissions by allowing speakers to submit to any conference powered by a CFP platform that's compatible with Symposium-right now we're working toward an OpenCFP integration.</div>
            </div>
        </div>
        <div class="px-8 py-12 max-w-md mx-auto sm:max-w-4xl">
            <h2 class="text-white text-center">Our Speakers</h2>
            <div class="flex content-between">
                <div class="p-8 text-white">Speaker</div>
                <div class="p-8 text-white">Speaker</div>
                <div class="p-8 text-white">Speaker</div>
                <div class="p-8 text-white">Speaker</div>
                <div class="p-8 text-white">Speaker</div>
                <div class="p-8 text-white">Speaker</div>
            </div>
            <div class="text-center">
                <a class="text-white border rounded p-4 mb-8" href="#">View all speakers</a>
            </div>
        </div>
    </div>

    <div class="bg-indigo-800">
        <div class="flex flex-col px-8 py-12 max-w-md mx-auto sm:max-w-4xl">
            <h2 class="text-white text-center">Conferences</h2>
            <div class="flex justify-between mb-16">
                <div class="text-center w-1/3 py-16 bg-white rounded">Conference</div>
                <div class="text-center w-1/3 mx-4 py-16 bg-white rounded">Conference</div>
                <div class="text-center w-1/3 py-16 bg-white rounded">Conference</div>
            </div>
            <div class="text-center">
                <a class="text-white border rounded p-4 mb-8" href="#">View all conferences</a>
            </div>
        </div>
    </div>

    <div class="bg-black">
        <div class="flex flex-col px-8 py-12 max-w-md mx-auto sm:max-w-4xl">
            <h2 class="text-white text-center">Ready to get started?</h2>
            <div class="flex">
                <input class="w-1/4 rounded" name="name" placeholder="Name">
                <input class="w-1/4 rounded" name="email" placeholder="Email">
                <input class="w-1/4 rounded" name="password" placeholder="Password">
                <input type="submit" class="w-1/4 rounded" value="Sign up">
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
