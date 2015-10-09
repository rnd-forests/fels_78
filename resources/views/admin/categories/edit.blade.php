@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Edit - {{ $category->name }}</strong>
                </div>
                <div class="panel-body">
                    {!! Form::model($category, ['method' => 'PATCH', 'route' => ['admin.categories.update', $category]]) !!}
                        @include('admin.categories.partials._main_form', ['categorySubmit' => 'Update Category'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
