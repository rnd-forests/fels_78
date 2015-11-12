@extends('layouts.default')
@section('title', 'All Members')
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
                                    <h4 class="media-heading">
                                        <a href="{{ route('users.show', $user) }}">
                                            {{ $user->name }}
                                        </a>
                                    </h4>
                                    <h5>{{ $user->email }}</h5>
                                    <h6>Joined on: {{ short_time($user->created_at) }}</h6>
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
