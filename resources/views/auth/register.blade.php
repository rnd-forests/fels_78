@extends('layouts.default')
@section('title', 'Sign Up')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        {!! error_text($errors, 'name') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control',
                            'placeholder' => 'username@example.com']) !!}
                        {!! error_text($errors, 'email') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        {!! error_text($errors, 'password') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Password Confirmation', ['class' => 'control-label']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign Up <i class="fa fa-arrow-right"></i></button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('auth.login') }}">Sign In</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop
