@extends('layouts.default')
@section('title', 'Categories')
@section('content')
    <div class="well-w">
        {{ trans('lesson.category.helper') }}
    </div>
    <div class="auto-pagination">
        @foreach($categories->chunk(4) as $categoryList)
            <div class="row item">
                @foreach($categoryList as $category)
                    <div class="col-md-3">
                        <div class="category">
                            <h4 class="category--title">{{ $category->name }}</h4>
                            <div class="category--details">{{ $category->description }}</div>
                            <div class="text-center">
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-default">
                                    Explore <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @include('layouts.partials._loader')
    {!! paginate($categories) !!}
@stop
