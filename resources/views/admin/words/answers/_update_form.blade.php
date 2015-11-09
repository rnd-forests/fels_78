<div class="collapse" id="{{ $answer->id }}-answer-update">
    {!! Form::model($answer, ['method' => 'PATCH',
    'route' => ['admin.answers.update', $answer],
    'class' => 'word--form__update-answer']) !!}
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::text('solution', null, ['class' => 'form-control']) !!}
                    {!! error_text($errors, 'solution') !!}
                </div>
                <input type="submit" class="hidden">
            </div>
        </div>
    {!! Form::close() !!}
</div>
