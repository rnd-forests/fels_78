@extends('layouts.admin')
@section('title', 'Categories')
@section('categorySubmit', 'Create')
@section('content')
    <div class="row">
        @if(blank($categories))
            @include('layouts.partials._empty')
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
                <table class="table table-bordered table-hover auto-pagination">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Words</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories->chunk(50) as $categoryList)
                        @foreach($categoryList as $category)
                            <tr class="item">
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    {!! link_to_route('admin.categories.words.index', counting($category->words), $category) !!}
                                </td>
                                <td>{{ short_time($category->created_at) }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-info btn-xs"
                                       title="Update">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {!! Form::delete('admin.categories.destroy', $category) !!}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($categories) !!}
        @endif
    </div>
    @include('admin.categories.partials._add_category_modal')
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
