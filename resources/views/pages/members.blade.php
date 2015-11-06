@extends('layouts.default')
@section('title', 'All Members')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="user-list auto-pagination">
                @foreach($members->chunk(15) as $userList)
                    @foreach($userList as $user)
                        <div class="user-block item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ route('user.profile.show', $user) }}">
                                        <img class="user-avatar-picture"
                                             src="{{ $user->present()->gravatar(isset($size) ? $size : 60) }}"
                                             alt="{{ $user->name }}">
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
