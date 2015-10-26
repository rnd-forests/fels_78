@extends('layouts.default')
@section('title', 'Sign In')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
                        <li><a href="{{ url('auth/password/email') }}">Reset your Password</a></li>
                    </ul>
                </div>
                @include('auth.partials._social_auth')
                @if(session('login_error'))
                    <div class="alert alert-danger text-center">
                        {!! session('login_error') !!}
                    </div>
                @endif
                {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        {!! error_text($errors, 'email') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        {!! error_text($errors, 'password') !!}
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="remember"> Remember me</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign In <i class="fa fa-arrow-right"></i></button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
