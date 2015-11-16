@extends('layouts.default')
@section('title', 'Word List')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well-w">
                @include('users.words.partials._filter_form')
            </div>
            <div class="well-w word--filter__info">
                {!! trans('word.filter.result', [
                    'wordCount' => plural('word', counting($words)),
                    'type' => $type,
                    'category' => $category->name,
                    'level' => $level,
                ]) !!}
            </div>
            <div class="list-group word--filter__results">
                @foreach($words as $word)
                    <div class="list-group-item word--filter__word">
                        {!! $word->present()->printContent() !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
