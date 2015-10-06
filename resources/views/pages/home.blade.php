@extends('layouts.default')
@section('title', 'Homepage')
@section('content')
    <div class="jumbotron">
        <h1>Framgia E-learning System</h1>

        <p>Welcome to FELS</p>
        @if(auth()->guest())
            <p>
                <a class="btn btn-primary btn-lg" href="{{ route('auth.login') }}">Sign In</a>
                <a class="btn btn-success btn-lg" href="{{ route('auth.register') }}">Sign Up</a>
            </p>
        @endif
    </div>
@stop