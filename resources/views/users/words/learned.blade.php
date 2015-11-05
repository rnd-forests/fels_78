@extends('layouts.default')
@section('title', 'Learned Words')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="well-w">
                <strong class="text-success text-uppercase">
                    {{ trans('word.learned', [
                        'wordCount' => plural('word', counting($words)),
                        'rank' => $currentUser->ranking
                    ]) }}
                </strong>
            </div>
            <div class="list-group auto-pagination">
                <div class="list-group-item">
                    {!! Form::open() !!}
                        <button type="submit" class="btn btn-primary">
                            Download <i class="fa fa-download"></i>
                        </button>
                    {!! Form::close() !!}
                </div>
                @foreach($words->load('category') as $word)
                    <div class="list-group-item word item">
                        <span class="word-info">{{ $word->content }}</span>
                        <small>on category</small>
                        <strong class="text-info">
                            <a href="{{ route('categories.show', $word->category) }}">
                                {{ $word->category->name }}
                            </a>
                        </strong>
                    </div>
                @endforeach
            </div>
            @include('layouts.partials._loader')
            {!! paginate($words) !!}
        </div>
    </div>
@stop
