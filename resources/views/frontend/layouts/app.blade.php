<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    @include('frontend.includes._stylesheets')
</head>
<body>

    @include('frontend.includes._header')

    @yield('content')

    @include('frontend.includes._footer')

    @include('frontend.includes._javascripts')
</body>
</html>