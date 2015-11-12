@include('layouts.partials._form_errors')
{!! Form::open(['method' => 'PATCH', 'route' => ['users.avatar', $user], 'files' => true]) !!}
    <div class="form-group">
        {!! Form::file('avatar') !!}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-upload"></i>
        </button>
    </div>
{!! Form::close() !!}
