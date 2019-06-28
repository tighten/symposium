<!DOCTYPE html>
<html>
<head>
    <title>Symposium for Speakers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('/packages/octicons/octicons.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.css') }}" rel="stylesheet">
    <link href="{{ url('/js/vendor/pickadate/default.date.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

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
<body>
    <div id="app">
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
    </div>

    <script src="//cdn.jsdelivr.net/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/zeroclipboard/2.2.0/ZeroClipboard.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
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
