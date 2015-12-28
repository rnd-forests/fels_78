@extends('layouts.root')
@section('content-layout')
    <div class="container">
        @if (auth()->guard('admin')->check())
            @include('layouts.partials._admin_nav')
        @endif
        @include('admin.search.search')
        @yield('content')
    </div>
@stop
