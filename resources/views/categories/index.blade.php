@extends('layouts.default')
@section('title', 'Categories')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                {{ trans('lesson.category.helper') }}
            </div>
            <div class="list-group auto-pagination">
                @foreach($categories->chunk(15) as $categoryList)
                    @foreach($categoryList as $category)
                        <div class="list-group-item item">
                            <h4 class="text-primary"><strong>{{ $category->name }}</strong></h4>
                            <p>{{ $category->description }}</p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-default">
                                Explore <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
            @include('layouts.partials._loader')
            {!! paginate($categories) !!}
        </div>
    </div>
@stop
