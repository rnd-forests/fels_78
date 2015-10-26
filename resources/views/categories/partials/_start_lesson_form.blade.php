{!! Form::open(['route' => ['categories.lessons.store', $category]]) !!}
    {!! Form::hidden('categoryId', $category->id) !!}
    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Start Lesson <i class="fa fa-arrow-right"></i>
        </button>
    </div>
{!! Form::close() !!}
