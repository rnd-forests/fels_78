@extends('layouts.default')
@section('title', $lesson->isFinished() ? 'Lesson Results' : 'Start Lesson')
@section('banner-content')
    <div class="banner">
        <div class="container">
            <div class="banner--content">
                @if($lesson->isFinished())
                    Lesson Results
                @else
                    {!! trans('lesson.guide', ['time' => $lesson->duration / 1000, 'word' => counting($lesson->words)]) !!}
                @endif
            </div>
        </div>
    </div>
@stop
@section('content')
    @if($lesson->isFinished())
        @include('categories.lessons.partials._results')
    @else
        @include('categories.lessons.partials._processing')
    @endif
@stop
