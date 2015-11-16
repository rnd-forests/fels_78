@extends('layouts.admin')
@section('title', $word->content)
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w word">
                <div class="pull-right">
                    {!! Form::delete('admin.words.destroy', $word) !!}
                </div>
                <div class="word--info pull-left">
                    <span class="word--info__content">{{ $word->content }}</span>
                    <span class="word--info__level">{{ $word->level }}</span>
                </div>
                <div class="clearfix"></div>
                <h4><small>in category: </small> {{ $word->category->name }}</h4>
                <h5><small>published at: </small> {{ humans_time($word->created_at) }}</h5>
                @include('admin.words.partials._update_word_form')
                <div class="list-group">
                    @foreach($word->answers as $answer)
                        <div class="list-group-item">
                            <div class="pull-right">
                                <button class="btn btn-default btn-xs"
                                        data-toggle="collapse"
                                        data-target="#{{ $answer->id }}-answer-update">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                {!! Form::delete('admin.answers.destroy', $answer, 'word--form__delete-answer') !!}
                            </div>
                            @if($answer->correct)
                                <span class="text-success">
                                    <i class="fa fa-check"></i>
                                    <strong class="solution">{{ $answer->solution }}</strong>
                                </span>
                            @else
                                <span class="text-danger">
                                <i class="fa fa-times"></i>
                                <strong class="solution">{{ $answer->solution }}</strong>
                            </span>
                            @endif
                            <h5><small>last edited: </small>{{ humans_time($answer->updated_at) }}</h5>
                            @include('admin.words.answers._update_form')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
