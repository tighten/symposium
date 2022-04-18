@php
    $is_home = request()->route()->getName() === 'home';
    $is_conferences = request()->route()->getName() === 'conferences.index';
@endphp

<!DOCTYPE html>
<html class="h-full">
<head>
    <title>Symposium for Speakers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://symposiumapp.com/">
    <meta property="og:image" content="{{ asset('img/symposium-banner.png') }}">
    
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://symposiumapp.com/">
    <meta property="twitter:title" content="{{ config('app.name') }}">
    <meta property="twitter:description" content="A web app for conference speakers to track talks, bios, and conferences.">
    <meta property="twitter:image" content="{{ asset('img/symposium-banner.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.date.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <script>
        var Symposium = {
            token: "{{ csrf_token() }}"
        };
    </script>
    @yield('headerScripts')
</head>
<body class="h-full">
    @php
        $app_bg_color = $is_home ? 'bg-white' : 'bg-indigo-100';
        $app_conferences = $is_conferences ? 'sm:max-w-5xl' : 'sm:max-w-3xl'
    @endphp
    <div id="app" class="min-h-full flex flex-col justify-between {{ $app_bg_color }}">
        <div class="flex-1">
            @include('partials.header', ['title' => $title ?? null])
            @if ($is_home)
                @yield('content')
            @else
                <div class="px-4 pb-8 bg-indigo-100 border-t-2 border-gray-200">
                    <div class="max-w-md pt-4 mx-auto {{ $app_conferences }}">
                        @yield('content')
                    </div>
                </div>
            @endif
        </div>
        @include('partials.footer', ['is_home' => $is_home])
    </div>

    <script src="//cdn.jsdelivr.net/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/zeroclipboard/2.2.0/ZeroClipboard.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places"></script>
    <script src="{{ ('/js/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ ('/js/vendor/pickadate/picker.date.js') }}"></script>
    <script src="{{ ('/js/app.js') }}"></script>
    @stack('scripts')

    @if (! App::isLocal())
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-40114814-6', 'auto');
        ga('send', 'pageview');
    </script>
    @endif
</body>
</html>
