<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! error_text($errors, 'name') !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 6]) !!}
    {!! error_text($errors, 'description') !!}
</div>
{!! Form::submitBtn($submit) !!}
