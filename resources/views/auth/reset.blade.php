@extends('layouts.default')
@section('title', 'Password Reset')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                @include('layouts.partials._form_errors')
                {!! Form::open(['url' => url('auth/password/reset')]) !!}
                    {!! Form::hidden('token', $token) !!}
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
                        <button type="submit" class="btn btn-primary">
                            Reset Password <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
