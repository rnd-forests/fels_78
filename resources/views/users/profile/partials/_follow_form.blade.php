{!! Form::open(['route' => 'follows.path', 'class' => 'follow-form']) !!}
    {!! Form::hidden('followed_id', $user->id) !!}
    {!! Form::submit('Follow', ['class' => 'btn btn-primary follow-button']) !!}
    <i class="fa fa-cog fa-spin fa-lg hidden"></i>
{!! Form::close() !!}
