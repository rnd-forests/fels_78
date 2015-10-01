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
                            Personal <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Account</a></li>
                            <li><a href="#">Sign Out</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            @if(auth()->guest())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Sign In</a></li>
                    <li><a href="#">Sign Up</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>