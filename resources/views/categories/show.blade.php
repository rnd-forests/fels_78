@extends('layouts.default')
@section('title', $category->name)
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('categories.partials._start_lesson_form')
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">Words of <strong>{{ $category->name }}</strong></div>
                <div class="list-group auto-pagination">
                    @foreach($words as $word)
                        <div class="list-group-item item">
                            <strong>{{ $word->content }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($words) !!}
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">Lessons of <strong>{{ $category->name }}</strong></div>
                <div class="list-group">
                    @if(blank($category->lessons))
                        <div class="list-group-item text-center">No lessons available.</div>
                    @else
                        @foreach($category->lessons as $lesson)
                            <li class="list-group-item">
                                <a href="{{ route('categories.lessons.show', [$category, $lesson]) }}">
                                    {{ $lesson->name }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
