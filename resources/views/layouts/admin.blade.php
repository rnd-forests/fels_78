@extends('layouts.root')
@section('content-layout')
    <div class="container">
        @include('layouts.partials._admin_nav')
        @include('flash::message')
        @yield('content')
        @include('layouts.partials._footer')
    </div>
    <script src="{{ elixir('js/all.js') }}"></script>
    @yield('footer')
@stop

