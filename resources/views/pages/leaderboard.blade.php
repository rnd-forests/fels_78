@extends('layouts.default')
@section('title', 'Leaderboard')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 leaderboard">
            <div class="well-w">
                <strong><i class="fa fa-trophy"></i> Memorized Words Leaderboard</strong>
            </div>
            @if(blank($users))
                @include('layouts.partials._empty')
            @else
                @foreach($users as $user)
                    <div class="media leaderboard--user">
                        <div class="media-left">
                            <a href="{{ route('users.show', $user) }}">
                                <img class="leaderboard--user__avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                            </a>
                            <span class="leaderboard--user__ranking">
                                {{ preg_split('/\//', $user->ranking)[0] }}
                            </span>
                        </div>
                        <div class="media-body">
                            <div class="leaderboard--user__info">
                                <h3 class="user-name">{{ $user->name }}</h3>
                                <p class="user-email">{{ $user->email }}</p>
                            </div>
                            <div class="pull-right leaderboard--user__meta">
                                <span class="learned-words-counter">
                                    {{ counting($user->words) }}
                                </span>
                                <span class="lesson-counter">
                                    {{ plural('lesson', $user->lessons()->finished()->count()) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@stop
