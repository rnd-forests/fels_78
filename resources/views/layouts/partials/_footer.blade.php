<footer class="footer">
    <a href="#" id="scroll-top"></a>
    <div class="pull-left">
        <h5>Framgia E-learning System</h5>
    </div>
    <div class="pull-right">
        <ul class="footer-links text-muted">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li>&middot;</li>
            <li><a href="{{ route('pages.about') }}">About</a></li>
            <li>&middot;</li>
            <li><a href="{{ route('pages.help') }}">Help</a></li>
            <li>&middot;</li>
            <li><a href="{{ route('pages.faq') }}">FAQ</a></li>
            <li>&middot;</li>
            @if(auth()->check())
                <li><a href="{{ route('auth.logout') }}">Sign Out</a></li>
            @endif
            @if(auth()->guest())
                <li><a href="{{ route('auth.login') }}">Sign In</a></li>
                <li>&middot;</li>
                <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
            @endif
        </ul>
    </div>
</footer>
