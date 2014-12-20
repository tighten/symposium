<nav>
	<ul class="primary-header__meta-nav">
		@if (Auth::check())
		<li><a href="/talks">Talks</a></li>
		<li><a href="/account">Account</a></li>
		<li><a href="/log-out">Log out</a></li>
		@else
		<li><a href="/what-is-this">What is this?</a></li>
		<li><a href="/log-in">Log in</a></li>
		<li><a href="/sign-up">Sign up</a></li>
		@endif
	</ul>
</nav>
