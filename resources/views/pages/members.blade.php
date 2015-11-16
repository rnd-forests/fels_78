@extends('layouts.default')
@section('title', 'Members')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="users auto-pagination">
                @foreach($members->chunk(15) as $userList)
                    @foreach($userList as $user)
                        <div class="users--user item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ route('users.show', $user) }}">
                                        <img class="users--user__avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{ route('users.show', $user) }}">
                                        <h4 class="media-heading">{{ $user->name }}</h4>
                                    </a>
                                    <p>{{ $user->email }}</p>
                                    <p>Joined on: {{ short_time($user->created_at) }}</p>
                                    <a href="{{ route('users.following.index', $user) }}">
                                        <span class="label label-default">
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
                        </div>
                    @endforeach
                @endforeach
            </div>
            @include('layouts.partials._loader')
            {!! paginate($members) !!}
        </div>
    </div>
@stop
