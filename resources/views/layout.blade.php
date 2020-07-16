@php
    $is_home = request()->route()->getName() === 'home';
@endphp

<!DOCTYPE html>
<html class="h-full">
<head>
    <title>Symposium for Speakers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.date.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
    @endphp
    <div id="app" class="min-h-full relative {{ $app_bg_color }}">
        @include('partials.header', ['title' => $title ?? null])
        @if ($is_home)
            @yield('content')
        @else
            <div class="bg-indigo-100 border-t-2 border-gray-200 pb-32 px-4">
                <div class="max-w-md mx-auto sm:max-w-3xl pt-4">
                    @yield('content')
                </div>
            </div>
        @endif
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
