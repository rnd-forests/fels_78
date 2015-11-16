@extends('layouts.default')
@section('title', 'Password Recovery')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @include('layouts.partials._form_errors')
                {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::email('email', null, ['class' => 'form-control',
                            'placeholder' => 'username@example.com']) !!}
                        {!! error_text($errors, 'email') !!}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Send Password Reset Link <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('auth.login') }}">Sign In</a></li>
                    <li><a href="{{ route('auth.register') }}">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop
