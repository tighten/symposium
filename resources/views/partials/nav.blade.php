<nav>
    <ul class="primary-header__meta-nav">
        @if (Auth::check())
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('bios.index') }}">Bios</a></li>
            <li><a href="{{ route('conferences.index') }}">Conferences</a></li>
            <li><a href="{{ route('talks.index') }}">Talks</a></li>
            <li class="dropdown" role="presentation">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <img src="{{ Gravatar::src(Auth::user()->email) }}" class="nav-profile-picture"> Me <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('account.show') }}">Account</a></li>
                    @if (Auth::user()->enable_profile)
                    <li><a href="{{ route('speakers-public.show', [Auth::user()->profile_slug]) }}">Public Speaker Profile</a></li>
                    @endif
                    <li><a href="{{ route('log-out') }}">Log out</a></li>
                </ul>
            </li>
        @else
            <li><a href="/what-is-this">What is this?</a></li>
            <li><a href="{{ route('log-in') }}">Log in</a></li>
            <li><a href="{{ route('sign-up') }}">Sign up</a></li>
        @endif
    </ul>
</nav>
