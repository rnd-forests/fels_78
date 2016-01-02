@extends('layouts.default')
@section('title', 'Members')
@section('banner-content')
    <div class="banner">
        <div class="container">
            <span class="banner--content">Find your friends</span>
        </div>
    </div>
@stop
@section('content')
    <div class="users auto-pagination">
        @foreach($members->chunk(4) as $userList)
            <div class="row item">
                @foreach($userList as $user)
                    <div class="col-md-3 users--user">
                        <a href="{{ route('users.show', $user) }}">
                            <img class="users--user__avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                        </a>
                        <div class="users--user__details">
                            <a href="{{ route('users.show', $user) }}">
                                <h4 class="users--user__name">{{ $user->name }}</h4>
                            </a>
                            <p>{{ $user->email }}</p>
                            <p>Joined on: {{ short_time($user->created_at) }}</p>
                            <a href="{{ route('users.following.index', $user) }}">
                                <span class="label label-info">
                                    {{ plural('following', counting($user->following)) }}
                                </span>
                            </a>
                            <a href="{{ route('users.followers.index', $user) }}">
                                <span class="label label-default">
                                    {{ plural('follower', counting($user->followers)) }}
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @include('layouts.partials._loader')
    {!! paginate($members) !!}
@stop
