@extends('layouts.admin')
@section('title', 'Words')
@section('content')
    <div class="row">
        @if(blank($words))
            @include('layouts.partials._empty')
        @else
            <div class="col-md-7">
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
            </div>
            <div class="col-md-5">
                @include('admin.words.partials._stats')
            </div>
        @endif
    </div>
@stop
