@extends('layouts.default')
@section('title', 'Home')
@section('content')
    @if(auth()->guest())
        <div class="jumbotron text-center" style="background: 0 0">
            <h1>Framgia E-learning System</h1>
            <img src="http://recruit.framgia.vn/assets/logo_framgia-8942793d84ada6ba4765a643ded3f89d.png"
                 alt="Framgia logo"
                 style="margin-bottom: 20px">
            <p>
                <a class="btn btn-home btn-lg" href="{{ route('auth.login') }}">Sign In</a>
                <a class="btn btn-home btn-lg" href="{{ route('auth.register') }}">Sign Up</a>
            </p>
        </div>
    @else
        <div class="row">
            <div class="col-md-3 user-sidebar">
                @include('users.profile.partials._profile_card', ['user' => $currentUser, 'size' => 250])
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-xs-6 text-center">
                        <a href="{{ route('words.index') }}" class="btn btn-home btn-lg">Words</a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a href="{{ route('categories.index') }}" class="btn btn-home btn-lg">Lessons</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Recent Activities</strong>
                    </div>
                    <div class="list-group auto-pagination">
                        @include('users.activity.activity_list')
                    </div>
                </div>
                @include('layouts.partials._loader')
                {!! paginate($activityList) !!}
            </div>
        </div>
    @endif
@stop
