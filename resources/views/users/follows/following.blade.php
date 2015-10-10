@extends('layouts.default')
@section('title', 'Following')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(blank($followings))
                <div class="well text-center">No user available</div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Users that <strong>{{ $user->name }}</strong> is following
                    </div>
                    <div class="list-group">
                        @foreach($followings as $following)
                            <div class="list-group-item">
                                <div class="media">
                                    <div class="media-left">
                                        @include('users.profile.partials._avatar', ['user' => $following])
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">{{ $following->name }}</h5>
                                        <p class="text-muted">{{ $following->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {!! paginate($followings) !!}
                </div>
            @endif
        </div>
    </div>
@stop
