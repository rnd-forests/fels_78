@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
    <div class="row">
        <div class="col-md-8">
            @if(blank($categories))
                <div class="text-center text-warning">No category available.</div>
            @else
                <div class="admin-wrapper">
                    <div class="panel panel-info">
                        <div class="panel-heading"><strong>List of categories</strong></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Published</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories->chunk(25) as $categoryList)
                                    @foreach($categoryList as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>{{ short_time($category->created_at) }}</td>
                                            <td>
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                   class="btn btn-info btn-xs"
                                                   data-toggle="tooltip"
                                                   data-placement="bottom"
                                                   title="Update this category">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                @include('admin.categories.partials._delete_form')
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! paginate($categories) !!}
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Add New Category</strong>
                </div>
                <div class="panel-body">
                    {!! Form::model($category = new \FELS\Entities\Category, ['route' => 'admin.categories.store']) !!}
                        @include('admin.categories.partials._main_form', ['categorySubmit' => 'Add'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
