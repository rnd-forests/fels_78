<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#keep-nav">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><strong>FELS</strong></a>
        </div>

        <div class="collapse navbar-collapse" id="keep-nav">
            <ul class="nav navbar-nav">
                @if(auth()->check())
                    <li class="dropdown">
                        <a href="#"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            {{ $currentUser->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('user.profile.edit', $currentUser) }}">Edit Profile</a></li>
                            <li><a href="{{ route('auth.logout') }}">Sign Out</a></li>
                        </ul>
                    </li>
                @endif
                <li><a href="{{ route('pages.about') }}">About</a></li>
                <li><a href="{{ route('pages.help') }}">Help</a></li>
                <li><a href="{{ route('pages.faq') }}">FAQ</a></li>
            </ul>
            @if(auth()->guest())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('auth.login') }}">Sign In</a></li>
                    <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>
