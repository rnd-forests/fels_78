@extends('layouts.default')
@section('title', 'Categories')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All Categories</div>
                <div class="list-group auto-pagination">
                    @foreach($categories->chunk(15) as $categoryList)
                        @foreach($categoryList as $category)
                            <div class="list-group-item item">
                                <i class="fa fa-folder"></i> <strong>{{ $category->name }}</strong>
                                <p>{{ $category->description }}</p>
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">
                                    Details <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($categories) !!}
        </div>
    </div>
@stop
