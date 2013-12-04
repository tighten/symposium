<!DOCTYPE html>
<html>
	<head>
		<title>Markedstyle preview for {{ $style->title }} style</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<style>
			{{ $style->source }}
		</style>
	</head>
	<body>
		<div id="wrapper">
			{{ $preview }}
		</div>
	</body>
</html>
