{!! Form::open(['method' => 'DELETE',
    'route' => ['admin.words.delete', $word],
    'class' => 'delete-word-form']) !!}
    <button type="submit"
            class="btn btn-danger btn-xs"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Delete this word">
        <i class="fa fa-times"></i>
    </button>
{!! Form::close() !!}
