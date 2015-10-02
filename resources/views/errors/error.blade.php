<!DOCTYPE html>
<html>
<head>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro" rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .container {
            margin-top: 100px;
        }

        .title {
            text-align: center;
            color: #f4645f;
            font-size: 60px;
        }

        .panel-heading {
            text-align: center;
        }

        .logo {
            color: #f4645f;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><span class="logo">FRAMGIA E-LEARNING SYSTEM</span> @yield('error-title')</div>
        <div class="panel-body">
            <div class="title">@yield('error-details')</div>
        </div>
    </div>
</div>
</body>
</html>
