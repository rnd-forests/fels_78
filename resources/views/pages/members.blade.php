@extends('layouts.default')
@section('title', 'All Members')
@section('content')
    <div class="row user-list auto-pagination">
        @foreach($members->chunk(6) as $userList)
            @foreach($userList as $user)
                <div class="col-md-2 user-block item">
                    <a href="{{ route('user.profile.show', $user) }}">
                        <img class="user-avatar-picture"
                             src="{{ $user->present()->gravatar(isset($size) ? $size : 120) }}"
                             alt="{{ $user->name }}">
                        <h5>{{ $user->name }}</h5>
                        <h6 class="text-muted">{{ $user->email }}</h6>
                    </a>
                </div>
            @endforeach
        @endforeach
    </div>
    @include('layouts.partials._loader')
    {!! paginate($members) !!}
@stop
