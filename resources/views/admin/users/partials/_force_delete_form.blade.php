{!! Form::open(['method' => 'DELETE', 'route' => ['admin.users.disabled.delete', $user]]) !!}
    <button type="submit"
            class="btn btn-danger btn-xs"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Permanently delete this account">
        <i class="fa fa-trash-o"></i>
    </button>
{!! Form::close() !!}
