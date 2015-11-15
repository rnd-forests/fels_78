@extends('layouts.default')
@section('title', $category->name)
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="well-w">
                @include('categories.partials._start_form')
            </div>
            <div class="well-w text-muted">
                {{ trans('lesson.lesson.types') }}
            </div>
            <div class="well-w">
                Your previous lessons
                <i class="fa fa-check text-success"></i> - finished --
                <i class="fa fa-times text-danger"></i> - not finished
            </div>
            @if(blank($lessons))
                @include('layouts.partials._empty')
            @else
                <div class="list-group auto-pagination">
                    @foreach($lessons as $lesson)
                        <div class="list-group-item item">
                            <a href="{{ $lesson->url }}">
                                {!! $lesson->present()->fullNameWithIcon() !!}
                            </a>
                        </div>
                    @endforeach
                </div>
                @include('layouts.partials._loader')
                {!! paginate($lessons) !!}
            @endif
        </div>
        <div class="col-md-6">
            <div class="well-w">
                You've learned {{ plural('word', counting($words)) }} in this category
            </div>
            @if(blank($words))
                @include('layouts.partials._empty')
            @else
                <div class="list-group auto-pagination">
                    @foreach($words as $word)
                        <div class="list-group-item item">
                            {!! $word->present()->printContent() !!}
                        </div>
                    @endforeach
                </div>
                @include('layouts.partials._loader')
                {!! paginate($words) !!}
            @endif
        </div>
    </div>
@stop
