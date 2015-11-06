@extends('layouts.default')
@section('title', $category->name)
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('categories.partials._start_lesson_form')
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    You've learned {{ plural('word', counting($words)) }}
                </div>
                <div class="list-group auto-pagination">
                    @if(blank($words))
                        <div class="list-group-item text-center">
                            No words available.
                        </div>
                    @else
                        @foreach($words as $word)
                            <div class="list-group-item item">
                                <strong>{{ $word->content }}</strong>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($words) !!}
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your previous lessons
                    <i class="fa fa-check text-success"></i> - finished /
                    <i class="fa fa-times text-warning"></i> - not finished
                </div>
                <div class="list-group">
                    @if(blank($lessons))
                        <div class="list-group-item text-center">
                            No lessons available.
                        </div>
                    @else
                        @foreach($lessons as $lesson)
                            <li class="list-group-item">
                                <a href="{{ $lesson->url }}">
                                    @if($lesson->isFinished())
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-warning"></i>
                                    @endif
                                    {{ $lesson->present()->fullName }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </div>
            </div>
            @include('layouts.partials._loader')
            {!! paginate($lessons) !!}
        </div>
    </div>
@stop
