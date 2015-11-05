<!DOCTYPE html>
@include('layouts.partials._conditions')
<head>
    @include('layouts.partials._common_head')
    @include('layouts.partials._shiv')
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
</body>
</html>
