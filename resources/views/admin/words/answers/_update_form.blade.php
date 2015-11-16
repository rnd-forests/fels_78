<div class="collapse" id="{{ $answer->id }}-answer-update">
    {!! Form::model($answer, ['method' => 'PATCH',
    'route' => ['admin.answers.update', $answer],
    'class' => 'word--form__update-answer']) !!}
        <div class="form-group">
            {!! Form::text('solution', null, ['class' => 'form-control']) !!}
        </div>
        <input type="submit" class="hidden">
    {!! Form::close() !!}
</div>
