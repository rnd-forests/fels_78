@extends('layouts.default')
@section('title', 'Following')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(blank($followings))
                @include('layouts.partials._empty')
            @else
                <div class="well-w">
                    Users that <strong>{{ $user->name }}</strong> is following
                </div>
                <div class="users auto-pagination">
                    @foreach($followings as $following)
                        <div class="users--user-2 item">
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ route('users.show', $following) }}">
                                        <img class="users--user__avatar" src="{{ $following->avatar }}" alt="{{ $following->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{ route('users.show', $following) }}">
                                        <h4 class="media-heading">{{ $following->name }}</h4>
                                    </a>
                                    <p class="text-muted">{{ $following->email }}</p>
                                    <p class="text-muted">Joined on: {{ short_time($following->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @include('layouts.partials._loader')
                {!! paginate($followings) !!}
            @endif
        </div>
    </div>
@stop
