@extends('layouts.default')
@section('title', 'Homepage')
@section('content')
    @if(auth()->guest())
        <div class="jumbotron">
            <h1>Framgia E-learning System</h1>
            <p>Welcome to FELS</p>
            <p>
                <a class="btn btn-primary btn-lg" href="{{ route('auth.login') }}">Sign In</a>
                <a class="btn btn-success btn-lg" href="{{ route('auth.register') }}">Sign Up</a>
            </p>
        </div>
    @else
        <div class="row">
            <div class="col-md-3 user-sidebar">
                @include('users.profile.partials._profile_card', ['user' => $currentUser, 'size' => 250])
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6 text-center">
                                <button type="button" class="btn btn-primary btn-lg">Words</button>
                            </div>
                            <div class="col-xs-6 text-center">
                                <button type="button" class="btn btn-primary btn-lg">Lessons</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <strong>Activities</strong>
                    </div>
                    <div class="panel-body">
                        ...
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
