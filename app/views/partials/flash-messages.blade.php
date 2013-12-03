@if(Session::has('success-message') || Session::has('error-message') || Session::has('message'))
	<div class="container">
		@if(Session::has('success-message'))
			<div class="alert alert-success">
				{{ Session::get('success-message') }}
			</div>
		@endif
		@if(Session::has('error-message'))
			<div class="alert alert-danger">
				{{ Session::get('error-message') }}
			</div>
		@endif
		@if(Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
	</div>
@endif
