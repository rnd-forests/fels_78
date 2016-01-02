@extends('layouts.default')
@section('title', 'Learned Words')
@section('banner-content')
    <div class="banner">
        <div class="container">
            <div class="banner--content">
                {{ trans('word.learned', [
                    'wordCount' => plural('word', counting($words)),
                    'rank' => $currentUser->ranking
                ]) }}
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(blank($words))
                @include('layouts.partials._empty')
            @else
                <div class="list-group auto-pagination">
                    <div class="list-group-item">
                        {!! Form::open() !!}
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i> Export PDF
                            </button>
                        {!! Form::close() !!}
                    </div>
                    @foreach($words->load('category') as $word)
                        <div class="list-group-item item">
                            {!! $word->present()->printContent() !!}
                            on category
                            <strong>
                                <a href="{{ route('categories.show', $word->category) }}">
                                    {{ $word->category->name }}
                                </a>
                            </strong>
                        </div>
                    @endforeach
                </div>
                @include('layouts.partials._loader')
                {!! paginate($words) !!}
            @endif
        </div>
    </div>
@stop
