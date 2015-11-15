{!! Form::open(['route' => 'follows.store', 'class' => 'follow-form']) !!}
    {!! Form::hidden('followed_id', $user->id) !!}
    <button type="submit" class="btn btn-default follow-button">
        <i class="fa fa-user-plus"></i> Follow
    </button>
    <i class="fa fa-cog fa-spin fa-lg uf-loading hidden"></i>
{!! Form::close() !!}
