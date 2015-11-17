<div class="lesson--helper">
    <div class="well-w">
        <div class="lesson--helper__timer">00:00</div>
        <div class="lesson--helper__progress">
            <span>0</span> • {{ counting($lesson->words) }}
        </div>
    </div>
    <div class="alert alert-success hidden lesson--helper__completed">
        <i class="fa fa-2x fa-cog fa-spin"></i>
        <p>{{ trans('lesson.completed') }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-success form-helper">
            {!! trans('lesson.guide', ['time' => $lesson->duration / 1000, 'word' => counting($lesson->words)]) !!}
        </div>
        {!! Form::open(['method' => 'PATCH',
            'route' => ['categories.lessons.update', $lesson->category, $lesson],
            'class' => 'lesson']) !!}
            {!! Form::hidden('lesson', $lesson->id) !!}
            <div class="list-group">
                {!! Form::normalBtn(trans('lesson.start'), 'btn-primary lesson--start', 'list-group-item') !!}
                @foreach($lesson->words->load('answers') as $word)
                    <div class="list-group-item">
                        <strong class="text-uppercase">{{ $word->content }}</strong>
                        @foreach($word->answers as $answer)
                            <div class="radio">
                                <label>
                                    {!! Form::radio("words[$word->id][choice]", $answer->id, null, ['class' => 'choice']) !!}
                                    {{ $answer->solution }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                {!! Form::submitBtn(trans('lesson.submit'), 'btn-primary lesson--submit', 'list-group-item') !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
