<nav>
    <ul class="primary-header__meta-nav">
        @if (Auth::check())
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/bios">Bios</a></li>
            <li><a href="/conferences">Conferences</a></li>
            <li><a href="/talks">Talks</a></li>
            <li class="dropdown" role="presentation">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <img src="{{ Gravatar::src(Auth::user()->email) }}" class="gravatar"> Me <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/account">Account</a></li>
                    <li><a href="/log-out">Log out</a></li>
                </ul>
            </li>
        @else
            <li><a href="/what-is-this">What is this?</a></li>
            <li><a href="/log-in">Log in</a></li>
            <li><a href="/sign-up">Sign up</a></li>
        @endif
    </ul>
</nav>
