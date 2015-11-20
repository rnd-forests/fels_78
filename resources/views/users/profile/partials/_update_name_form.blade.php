@if (session('invalid.name'))
    <div class="alert alert-warning">{{ session('invalid.name') }}</div>
@endif
{!! Form::open(['method' => 'PATCH', 'route' => ['users.name', $user]]) !!}
    <div class="form-group">
        {!! Form::label('old_name', 'Current name', ['class' => 'control-label']) !!}
        {!! Form::text('old_name', null, ['class' => 'form-control']) !!}
        {!! error_text($errors, 'old_name') !!}
    </div>
    <div class="form-group">
        {!! Form::label('new_name', 'New name', ['class' => 'control-label']) !!}
        {!! Form::text('new_name', null, ['class' => 'form-control']) !!}
        {!! error_text($errors, 'new_name') !!}
    </div>
    {!! Form::submitBtn('Update') !!}
{!! Form::close() !!}
