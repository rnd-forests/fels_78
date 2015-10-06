@extends('layouts.default')
@section('title', 'Password Recovery . Keep')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default form-wrapper">
                <div class="panel-heading">Get password reset link</div>
                <div class="panel-body">
                    {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control',
                            'placeholder' => 'username@example.com']) !!}
                        {!! error_text($errors, 'email') !!}
                    </div>
                    <div class="form-group form-submit">
                        {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="panel-footer">
                    <ol class="list-inline">
                        <li><a href="{{ route('auth.login') }}">Sign In</a></li>
                        <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop
