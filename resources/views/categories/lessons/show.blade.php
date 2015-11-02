@extends('layouts.default')
@section('title', 'Start Lesson')
@section('content')
    <div class="lesson-helper">
        <div class="well-w">
            <div class="text-success text-center" id="lesson-timer">
                <i class="fa fa-clock-o"></i> 00:01:00
            </div>
        </div>
        <div class="well-w">
            <div class="text-center lesson-progress">
                <i class="fa fa-spinner fa-spin"></i> <span>0</span> / {{ counting($lesson->words) }}
            </div>
        </div>
        <div class="alert alert-success text-center hidden lesson-completed">
            <i class="fa fa-2x fa-cog fa-spin"></i>
            <p>{{ trans('lesson.completed') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-info form-helper">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ trans('lesson.guide') }}
            </div>
            {!! Form::open(['method' => 'PATCH',
                'route' => ['categories.lessons.update', $lesson->category, $lesson],
                'class' => 'lesson-form']) !!}
                {!! Form::hidden('lesson', $lesson->id) !!}
                <div class="list-group">
                    <div class="list-group-item">
                        <buton type="button" class="btn btn-primary lesson-start">
                            {{ trans('lesson.start') }} <i class="fa fa-arrow-right"></i>
                        </buton>
                    </div>
                    @foreach($lesson->words->load('answers') as $word)
                        <div class="list-group-item">
                            <strong class="text-uppercase">{{ $word->content }}</strong>
                            @foreach($word->answers as $answer)
                                <div class="radio">
                                    <label>
                                        {!! Form::radio("words[$word->id][choice]", $answer->id,
                                            null, ['class' => 'choice']) !!}
                                        {{ $answer->solution }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="list-group-item">
                        <button type="submit" class="btn btn-primary lesson-submit">
                            {{ trans('lesson.submit') }} <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
