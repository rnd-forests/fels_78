@extends('layouts.admin')
@section('title', 'Admin Login')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
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
                {!! Form::submitBtn('Sign In') !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
