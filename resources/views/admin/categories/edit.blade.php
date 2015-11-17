@extends('layouts.admin')
@section('title', 'Edit Category')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                {!! Form::model($category, ['method' => 'PATCH', 'route' => ['admin.categories.update', $category]]) !!}
                    @include('admin.categories.partials._main_form', ['submit' => 'Update'])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
