<nav class="navbar navbar-inverse navbar-fixed-top">
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
            <a class="navbar-brand" href="{{ route('admin.users') }}"><strong>FELS</strong></a>
        </div>

        <div class="collapse navbar-collapse" id="keep-nav">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown">
                        Accounts <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.users') }}">Current</a></li>
                        <li><a href="{{ route('admin.users.disabled') }}">Disabled</a></li>
                        <li><a href="{{ route('admin.users.create') }}">Add New Account</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.categories') }}">Categories</a></li>
                <li><a href="{{ route('admin.words') }}">Words</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown">
                        Actions <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('auth.logout') }}">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
