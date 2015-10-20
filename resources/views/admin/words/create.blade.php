@extends('layouts.admin')
@section('title', 'New Word')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                {!! Form::open(['route' => 'admin.words.store']) !!}
                    @include('admin.words.partials._main_form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
