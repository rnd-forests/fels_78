@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(blank($categories))
                <div class="text-center text-warning">No category available.</div>
            @else
                <div class="admin-wrapper">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <strong class="text-info">{{ plural('CATEGORY', counting($categories)) }}</strong>
                            <div class="pull-right">
                                <button type="button"
                                        class="btn btn-primary btn-xs"
                                        data-toggle="modal"
                                        data-target="#add-category">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover auto-pagination">
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
                                    <tr class="item">
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
                @include('layouts.partials._loader')
                {!! paginate($categories) !!}
            @endif
        </div>
    </div>
    <div class="modal fade" id="add-category" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($category = new \FELS\Entities\Category, ['route' => 'admin.categories.store']) !!}
                        @include('admin.categories.partials._main_form', ['categorySubmit' => 'Add'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    @if($errors->all())
        <script>
            $(function () {
                $('#add-category').modal('show');
            });
        </script>
    @endif
@stop
