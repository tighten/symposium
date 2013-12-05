<nav>
	<ul class="primary-header__meta-nav">
		<li><a href="/">Home</a></li>
		<li><a href="/styles">Browse Styles</a></li>
		@if (Auth::check())
		<li><a href="/account">Account</a></li>
		<li><a href="/logout">Log out</a></li>
		@else
		{{-- <li><a href="/login">Log in</a></li> --}}
		@endif
	</ul>
</nav>
