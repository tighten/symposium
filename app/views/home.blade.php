@extends('layout')

@section('content')

<div class="hero">
	<div class="container">
		<h1>Style your markdown!</h1>
		<p>Markedstyle is a collection of CSS files for styling the <a href="http://marked2app.com/">Marked</a> markdown preview app.</p>
		<p><a href="/styles" class="button button--primary button--large" role="button">Browse Styles &raquo;</a></p>
	</div>
</div>
	
<div class="container" style="display: none;">
	<div class="row">
		<div class="col-third">
			<h2>Heading</h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
			<p><a class="button button--default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-third">
			<h2>Heading</h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
			<p><a class="button button--default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-third">
			<h2>Heading</h2>
			<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
			<p><a class="button button--default" href="#" role="button">View details &raquo;</a></p>
		</div>
	</div>
</div>
@stop
