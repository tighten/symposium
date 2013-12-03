		<div class="primary-header" role="navigation">
			<div class="container">
				<div class="primary-header__title">
					<button type="button" class="primary-header__toggle" data-toggle="collapse" data-target=".primary-header__collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/" class="navbar-brand"><h1>Markedstyle</h1></a>
				</div>
				<div class="primary-header__collapse">
					<nav>
						<ul class="primary-header__meta-nav">
							<li><a href="/">Home</a></li>
							@if (Auth::check())
							<li><a href="/account">Account</a></li>
							<li><a href="/logout">Log out</a></li>
							@else
							<li><a href="/login">Log in</a></li>
						@endif
						</ul>
					</nav>
				</div><!--/.navbar-collapse -->
			</div>
		</div>

@include('partials.flash-messages')
