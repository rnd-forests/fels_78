{!! Form::model($word, ['method' => 'PATCH',
    'route' => ['admin.words.update', $word],
    'class' => 'word-update-form']) !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {!! Form::text('content', null, ['class' => 'form-control']) !!}
                {!! error_text($errors, 'content') !!}
            </div>
            <input type="submit" style="display:none">
        </div>
    </div>
{!! Form::close() !!}
