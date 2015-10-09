{!! Form::open(['method' => 'DELETE', 'route' => ['admin.users.delete', $user]]) !!}
    <button type="submit"
            class="btn btn-danger btn-xs"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Disable this account">
        <i class="fa fa-times"></i>
    </button>
{!! Form::close() !!}
