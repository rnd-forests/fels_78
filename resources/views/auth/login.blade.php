@extends('layouts.default')
@section('title', 'Sign In')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default form-wrapper">
                <div class="panel-heading">Sign in with your account</div>
                <div class="panel-body">
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
                    <div class="form-group form-submit">
                        {!! Form::submit('Sign In', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                    <ol class="list-inline">
                        <li><a href="{{ url('auth/password/email') }}">Reset your Password</a></li>
                        <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop
