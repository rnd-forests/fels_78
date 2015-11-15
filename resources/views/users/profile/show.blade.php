@extends('layouts.default')
@section('title', $user->name)
@section('content')
    <div class="row">
        <div class="col-md-3 users">
            @include('users.profile.partials._profile_card')
        </div>
        <div class="col-md-9">
            @if(blank($activityList))
                <div class="well-w">
                    {{ $user->name }} doesn't have any activities to show.
                </div>
            @else
                <div class="list-group auto-pagination">
                    @include('users.activity.activity_list')
                </div>
                @include('layouts.partials._loader')
                {!! paginate($activityList) !!}
            @endif
        </div>
    </div>
@stop
