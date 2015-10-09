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
                    <div class="form-wrapper">
                        <div class="panel panel-default form-wrapper">
                            <div class="panel-body">
                                @include('users.profile.partials._update_name_form')
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="update-password">
                    <div class="panel panel-default form-wrapper">
                        <div class="panel-body">
                            @include('users.profile.partials._update_password_form')
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cancel-account">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading">Cancel your account</div>
                        <div class="panel-body">
                            <div class="alert alert-danger" role="alert">
                                Once your account is deleted, the system will
                                immediately delete all things related to your account.
                            </div>
                            {!! Form::open(['route' => ['user.profile.destroy', $user], 'method' => 'DELETE']) !!}
                                {!! Form::submit('Confirm &amp; Cancel', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
