{!! Form::open(['method' => 'GET', 'route' => ['words.index'], 'class' => 'word--filter__form']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('in-category', 'Category', ['class' => 'control-label']) !!}
                {!! Form::select('in-category', $categories, null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('with-level', 'Difficulty Level', ['class' => 'control-label']) !!}
                {!! Form::select('with-level', array_merge([\FELS\Entities\Word::COMBINED => \FELS\Entities\Word::COMBINED],
                \FELS\Entities\Word::getLevels()), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <p><i class="fa fa-filter"></i> Choose filtering option</p>
        <label class="radio-inline">
            {!! Form::radio('filter-by', \FELS\Entities\Word::LEARNED, true) !!} Learned words
        </label>
        <label class="radio-inline">
            {!! Form::radio('filter-by', \FELS\Entities\Word::UNLEARNED) !!} Unlearned words
        </label>
        <label class="radio-inline">
            {!! Form::radio('filter-by', \FELS\Entities\Word::ALPHABET) !!} All words (alphabetical order)
        </label>
    </div>
    {!! Form::submitBtn('Filter') !!}
{!! Form::close() !!}
