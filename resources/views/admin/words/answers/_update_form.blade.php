<div class="collapse" id="{{ $answer->id }}-answer-update">
    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::model($answer, ['method' => 'PATCH',
            'route' => ['admin.answers.update', $answer],
            'class' => 'answer-update-form']) !!}
                <div class="form-group">
                    {!! Form::text('solution', null, ['class' => 'form-control']) !!}
                    {!! error_text($errors, 'solution') !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Update <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
