@extends('layouts.default')
@section('title', $user->name)
@section('content')
    <div class="row">
        <div class="col-md-3 user-sidebar">
            @include('users.profile.partials._profile_card', ['size' => 250])
            @unless($user->is($currentUser))
                @include('users.profile.partials._relationship_form')
            @endunless
        </div>
        <div class="col-md-9">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <strong>Activities</strong>
                </div>
                <div class="list-group auto-pagination">
                    @include('users.activity.activity_list')
                </div>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($activityList) !!}
        </div>
    </div>
@stop
