@extends('layouts.root')
@section('content-layout')
    <header>
        @include('layouts.partials._main_nav')
        @yield('banner-content')
    </header>
    <div class="container">
        @yield('content')
    </div>
    @include('layouts.partials._footer')
@stop
