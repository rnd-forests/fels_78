{!! Form::open(['method' => 'DELETE',
    'route' => ['admin.answers.delete', $answer],
    'class' => 'delete-answer-form']) !!}
    <button type="submit"
            class="btn btn-default btn-xs"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Delete this answer">
        <i class="fa fa-trash-o"></i>
    </button>
{!! Form::close() !!}
