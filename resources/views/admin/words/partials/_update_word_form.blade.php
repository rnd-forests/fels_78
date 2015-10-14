<div class="panel panel-default">
    <div class="panel-body">
        {!! Form::model($word, ['method' => 'PATCH',
            'route' => ['admin.words.update', $word],
            'class' => 'word-update-form']) !!}
            <div class="form-group">
                {!! Form::label('content', 'Word Content', ['class' => 'control-label']) !!}
                {!! Form::text('content', null, ['class' => 'form-control']) !!}
                {!! error_text($errors, 'content') !!}
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-sm" type="submit">
                    Update <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
