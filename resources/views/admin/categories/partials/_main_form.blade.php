<div class="form-group">
    {!! Form::label('name', 'Category Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    {!! error_text($errors, 'name') !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Category Description', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 6]) !!}
</div>
<div class="form-group form-submit">
    {!! Form::submit($categorySubmit, ['class' => 'btn btn-primary']) !!}
</div>