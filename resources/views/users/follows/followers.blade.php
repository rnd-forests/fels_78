@extends('layouts.default')
@section('title', 'Followers')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(blank($followers))
                @include('layouts.partials._empty')
            @else
                <div class="well-w">
                    Users that are following <strong>{{ $user->name }}</strong>
                </div>
                <div class="users auto-pagination">
                    @foreach($followers as $follower)
                        <div class="users--user-2 item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ route('users.show', $follower) }}">
                                        <img class="users--user__avatar" src="{{ $follower->avatar }}" alt="{{ $follower->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{ route('users.show', $follower) }}">
                                        <h4 class="media-heading">{{ $follower->name }}</h4>
                                    </a>
                                    <p class="text-muted">{{ $follower->email }}</p>
                                    <p class="text-muted">Joined on: {{ short_time($follower->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @include('layouts.partials._loader')
                {!! paginate($followers) !!}
            @endif
        </div>
    </div>
@stop
