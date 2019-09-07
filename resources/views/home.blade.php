@extends('layout')

@section('content')
    <div class="hero">
        <div class="container">
            <h1>Connecting Speakers &amp; Conferences</h1>

            <div class="row">
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
                    @if (Auth::guest())
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
                                    <a class="inline-block my-1 p-2 border border-gray-800 rounded text-lg text-gray-800 hover:bg-blue-500 hover:border-blue-500 hover:text-white hover:no-underline" href="{{ url('login/github') }}">Log in with <strong>GitHub</strong> @svg('github', 'inline-block align-top h-6 w-6')</a>
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
            </div>
        </div>
    </div>

    <!--<a href="/im-a-bot">I'm a bot</a>-->
@stop
