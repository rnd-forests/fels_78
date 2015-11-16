<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description')">
    <title>@yield('title') | Framgia E-learning System</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,600' rel='stylesheet'>
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    @yield('content-layout')
    @if(session('app_status'))
        <script>
            @if(session('app_status') == 'login_success')
                swal({
                    title: 'Hi, Again!',
                    text: 'You are now logged in!',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            @endif
        </script>
    @endif
    <script src="{{ elixir('js/all.js') }}"></script>
    @yield('footer')
</body>
</html>
