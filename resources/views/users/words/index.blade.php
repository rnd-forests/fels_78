@extends('layouts.default')
@section('title', 'Word List')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well-w">
                {!! Form::open(['method' => 'GET',
                'route' => ['words.index'],
                'id' => 'word-filter-form']) !!}
                    <div class="form-group">
                        {!! Form::label('in-category', 'Category', ['class' => 'control-label']) !!}
                        {!! Form::select('in-category', $categories, null, ['class' => 'form-control']) !!}
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Filter <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="well-w filter-info">
                {!! trans('word.filter.result', [
                    'wordCount' => plural('word', counting($words)),
                    'type' => $type,
                    'category' => $category->name
                ]) !!}
            </div>
            <div class="list-group filtered-words auto-pagination">
                @foreach($words as $word)
                    <div class="list-group-item word item">
                        <span class="word--info">{{ $word->content }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
