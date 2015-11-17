{!! Form::open(['route' => ['categories.lessons.store', $category]]) !!}
    {!! Form::hidden('categoryId', $category->id) !!}
    <div class="form-group">
        <p><i class="fa fa-filter"></i> Choose your lesson type</p>
        <label class="radio-inline">
            {!! Form::radio('lessonType', \FELS\Entities\Word::HARD, true) !!} Hard words
        </label>
        <label class="radio-inline">
            {!! Form::radio('lessonType', \FELS\Entities\Word::MEDIUM) !!} Medium words
        </label>
        <label class="radio-inline">
            {!! Form::radio('lessonType', \FELS\Entities\Word::EASY) !!} Easy words
        </label>
        <label class="radio-inline">
            {!! Form::radio('lessonType', \FELS\Entities\Word::COMBINED) !!} Random words
        </label>
    </div>
    {!! Form::submitBtn('Start Lesson', 'btn-success') !!}
{!! Form::close() !!}
