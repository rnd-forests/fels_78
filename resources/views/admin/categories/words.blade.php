@extends('layouts.admin')
@section('title', 'Words - ' . $category->name)
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well-w">
                <div class="text-center">
                    {{ plural('word', counting($words)) }} of <strong>{{ $category->name }}</strong>
                </div>
            </div>
            @if(blank($words))
                @include('layouts.partials._empty')
            @else
                <div class="admin-wrapper">
                    <div class="panel panel-default">
                        <div class="list-group auto-pagination">
                            @foreach($words->chunk(50) as $wordList)
                                @foreach($wordList as $word)
                                    <div class="list-group-item item word">
                                        @include('admin.words.partials._word')
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('layouts.partials._loader')
                {!! paginate($words) !!}
            @endif
        </div>
    </div>
@stop
