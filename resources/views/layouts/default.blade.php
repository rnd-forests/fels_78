@extends('layouts.root')
@section('content-layout')
    <div class="container">
        @include('layouts.partials._main_nav')
        @include('flash::message')
        @yield('content')
        @include('layouts.partials._footer')
    </div>
@stop
