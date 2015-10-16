@extends('layouts.admin')
@section('title', 'All Words')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(blank($words))
                <div class="text-center text-warning">No word available.</div>
            @else
                <div class="admin-wrapper">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <strong class="text-info">{{ plural('WORD', counting($words)) }}</strong>
                            <div class="pull-right">
                                <a href="{{ route('admin.words.create') }}"
                                   class="btn btn-primary btn-xs"
                                   data-toggle="tooltip"
                                   data-placement="bottom"
                                   title="Add a new word">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="list-group auto-pagination word-list">
                            @foreach($words->chunk(50) as $wordList)
                                @foreach($wordList as $word)
                                    @include('admin.words.partials._word')
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
