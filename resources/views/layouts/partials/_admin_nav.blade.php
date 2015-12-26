<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fels-nav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin.users.index') }}">FELS</a>
        </div>
        <div class="collapse navbar-collapse" id="fels-nav">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Accounts <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.users.index') }}">Current</a></li>
                        <li><a href="{{ route('admin.users.disabled') }}">Disabled</a></li>
                        <li><a href="{{ route('admin.users.create') }}">Add New Account</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li><a href="{{ route('admin.words.index') }}">Words</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" data-toggle="collapse" data-target="#admin-search">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li><a href="{{ route('admin.logout') }}">Sign Out</a></li>
            </ul>
        </div>
    </div>
</nav>
