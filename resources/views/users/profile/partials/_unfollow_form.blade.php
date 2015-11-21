{!! Form::open(['method' => 'DELETE', 'route' => ['follows.destroy', $user->id], 'class' => 'unfollow-form']) !!}
    {!! Form::hidden('followed_id', $user->id) !!}
    <button type="submit" class="btn btn-danger unfollow-button">
        <i class="fa fa-user-times"></i> Unfollow
    </button>
{!! Form::close() !!}
