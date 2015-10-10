{!! Form::open(['method' => 'DELETE', 'route' => ['follow.path', $user->id], 'class' => 'unfollow-form']) !!}
    {!! Form::hidden('followed_id', $user->id) !!}
    {!! Form::submit('Unfollow', ['class' => 'btn btn-warning unfollow-button']) !!}
    <i class="fa fa-cog fa-spin fa-lg hidden"></i>
{!! Form::close() !!}
