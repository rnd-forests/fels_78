@extends('layouts.default')
@section('title', 'Edit Profile')
@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="col-md-4">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="active">
                    <a href="#update-name" role="tab" data-toggle="tab">Change Current Name</a>
                </li>
                <li role="presentation">
                    <a href="#update-password" role="tab" data-toggle="tab">Change Current Password</a>
                </li>
                <li role="presentation">
                    <a href="#cancel-account" role="tab" data-toggle="tab">Cancel Account</a>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="update-name">
                    <div class="well-w">
                        @include('users.profile.partials._update_name_form')
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="update-password">
                    <div class="well-w">
                        @include('users.profile.partials._update_password_form')
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cancel-account">
                    <div class="well-w">
                        <div class="alert alert-danger" role="alert">
                            Once your account is deleted, the system will
                            immediately delete everything related to your account.
                        </div>
                        {!! Form::open(['route' => ['user.profile.destroy', $user], 'method' => 'DELETE']) !!}
                        <button type="submit" class="btn btn-danger">Confirm <i class="fa fa-arrow-right"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
