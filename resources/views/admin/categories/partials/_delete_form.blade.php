{!! Form::open(['method' => 'DELETE', 'route' => ['admin.categories.delete', $category]]) !!}
    <button type="submit"
            class="btn btn-danger btn-xs"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Delete this category">
        <i class="fa fa-times"></i>
    </button>
{!! Form::close() !!}
