<!DOCTYPE html>
<html>
	<head>
		{{ stylesheet('app.css') }}
		<title>Markedstyle</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		@include('partials.header')
		@yield('content')
		@include('partials.footer')

		{{ script('vendor/jquery-2.0.3.min.js') }}
		{{ script('main.js') }}
	</body>
</html>
