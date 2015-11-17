@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
    <div class="row">
        @if(blank($categories))
            @include('layouts.partials._empty')
        @else
            <div class="admin-wrapper">
                <div class="well-w">
                    <strong>{{ plural('CATEGORY', counting($categories)) }}</strong>
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary btn-xs"
                                data-toggle="modal" data-target="#add-category">
                            <i class="fa fa-plus"></i>
                        </button>
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
                                           class="btn btn-info btn-xs" title="Update">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        {!! Form::delete('admin.categories.destroy', $category) !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                @include('layouts.partials._loader')
                {!! paginate($categories) !!}
            </div>
        @endif
    </div>
    <div class="modal" id="add-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    {!! Form::model($category = new \FELS\Entities\Category, ['route' => 'admin.categories.store']) !!}
                        @include('admin.categories.partials._main_form', ['submit' => 'Create'])
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
