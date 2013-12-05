<nav>
	<ul class="primary-header__meta-nav">
		<li><a href="/">Home</a></li>
		<li><a href="/styles">Browse Styles</a></li>
		@if (Auth::check())
		<li><a href="/account">Account</a></li>
		<li><a href="/log-out">Log out</a></li>
		@else
		<li><a href="/how-do-i">How do I...</a></li>
		<li><a href="/log-in">Log in</a></li>
		<li><a href="/sign-up">Sign up</a></li>
		@endif
	</ul>
</nav>
