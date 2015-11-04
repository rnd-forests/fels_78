@extends('layouts.default')
@section('title', $lesson->isFinished() ? 'Lesson Results' : 'Start Lesson')
@section('content')
    @if($lesson->isFinished())
        @include('categories.lessons.partials._results')
    @else
        @include('categories.lessons.partials._processing')
    @endif
@stop
