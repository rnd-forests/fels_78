{!! Form::model($word, ['method' => 'PATCH',
    'route' => ['admin.words.update', $word],
    'class' => 'word--form__update-word']) !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                {!! Form::text('content', null, ['class' => 'form-control']) !!}
                {!! error_text($errors, 'content') !!}
            </div>
            <input type="submit" class="hidden">
        </div>
    </div>
{!! Form::close() !!}
