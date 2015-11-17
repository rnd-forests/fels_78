<div class="alert alert-success form-helper">
    {!! trans('user.avatar.helper') !!}
</div>
{!! Form::open(['method' => 'PATCH', 'route' => ['users.avatar', $user], 'files' => true]) !!}
    <div class="form-group">
        {!! Form::file('avatar') !!}
        {!! error_text($errors, 'avatar') !!}
    </div>
    {!! Form::submitBtn('Upload') !!}
{!! Form::close() !!}
