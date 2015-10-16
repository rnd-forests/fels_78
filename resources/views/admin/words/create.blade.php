@extends('layouts.admin')
@section('title', 'Create New Word')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Add A New Word</div>
                <div class="panel-body">
                    {!! Form::open(['route' => 'admin.words.store']) !!}
                        @include('admin.words.partials._main_form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
