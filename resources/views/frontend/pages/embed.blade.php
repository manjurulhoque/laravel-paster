<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>Embed - {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/prism-okadia.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="card">
    <div class="card-header"> {{$paste->title}} - <span
                class="badge badge-light">{{ strtoupper($paste->syntax) }}</span>
        <small class="text-muted">{{$paste->content_size}} KB</small>
        <div class="pull-right">
            <a href="{{ route('paste.raw', $paste->slug) }}" class="buttonsm">raw</a>
            <a href="{{ route('paste.download', $paste->slug) }}" class="buttonsm">download</a>
        </div>
    </div>
    <div class="card-body p-2">
        <pre class="line-numbers language-{{$paste->syntax}}" id="pre">
            <code class="language-{{$paste->syntax}}">
                {{$paste->content}}
            </code>
        </pre>
        <p class="text-center p-0">
            Paste Hosted With <i class="fa fa-heart"></i> By<a href="{{ url('/') }}"
                                                               target="_blank">{{ env('APP_NAME') }}</a>
        </p>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/prism.js') }}"></script>
<script src="{{ asset('js/prisma-custom.js') }}"></script>
</body>
</html>