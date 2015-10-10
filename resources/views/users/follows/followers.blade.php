@extends('layouts.default')
@section('title', 'Followers')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(blank($followers))
                <div class="well text-center">No user available</div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Users that are following <strong>{{ $user->name }}</strong>
                    </div>
                    <div class="list-group">
                        @foreach($followers as $follower)
                            <div class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
                                        @include('users.profile.partials._avatar', ['user' => $follower])
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">{{ $follower->name }}</h5>
                                        <p class="text-muted">{{ $follower->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {!! paginate($followers) !!}
                </div>
            @endif
        </div>
    </div>
@stop
