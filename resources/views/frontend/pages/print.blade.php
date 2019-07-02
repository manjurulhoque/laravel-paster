<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>Print - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/prism-okadia.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body onload="window.print();">
<div class="card">
    <div class="card-header"> {{$paste->title}} - <span
                class="badge badge-light">{{strtoupper($paste->syntax)}}</span>
        <small class="text-muted">{{$paste->content_size}} KB</small>
    </div>
    <div class="card-body" style="padding: 2px;">
        <pre class="line-numbers language-{{$paste->syntax}}">
            <code class="language-{{$paste->syntax}}">
                {{$paste->content}}
            </code>
        </pre>
        <p class="text-center p-0">Paste Hosted With <i class="fa fa-heart"></i> By
            <a href="{{ url('/') }}" target="_blank">{{ env('APP_NAME') }}</a>
        </p>
    </div>
</div>

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/prism.js') }}"></script>
<script src="{{ asset('js/prisma-custom.js') }}"></script>
</body>
</html>