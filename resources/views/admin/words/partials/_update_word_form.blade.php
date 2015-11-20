{!! Form::model($word, ['method' => 'PATCH',
    'route' => ['admin.words.update', $word],
    'class' => 'word--form__update-word form-inline']) !!}
    <div class="form-group">
        {!! Form::text('content', $word->content, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('level', \FELS\Entities\Word::getLevels(), $word->level, ['class' => 'form-control']) !!}
    </div>
    {!! Form::submitBtn('Change') !!}
{!! Form::close() !!}
