@extends('layouts.default')
@section('title', 'Settings')
@section('banner-content')
    <div class="banner">
        <div class="container">
            <span class="banner--content">Update your current profile</span>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="nav nav-tabs">
                <li><a href="#update-name" data-toggle="tab" class="active">Name</a></li>
                <li><a href="#update-password" data-toggle="tab">Password</a></li>
                <li><a href="#update-avatar" data-toggle="tab">Avatar</a></li>
                <li><a href="#cancel-account" data-toggle="tab">Cancel Account</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="update-name">
                    @include('users.profile.partials._update_name_form')
                </div>
                <div class="tab-pane" id="update-password">
                    @include('users.profile.partials._update_password_form')
                </div>
                <div class="tab-pane" id="update-avatar">
                    <div class="row">
                        <div class="col-sm-6">
                            @include('users.profile.partials._update_avatar_form')
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('users.show', $user) }}">
                                <img class="user--avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="cancel-account">
                    <div class="alert alert-danger" role="alert">
                        {!! trans('user.account.warning') !!}
                    </div>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user]]) !!}
                        {!! Form::submitBtn('Cancel Account', 'btn-danger') !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
