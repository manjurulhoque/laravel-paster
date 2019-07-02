<html>
<head>
    <title>{{ env('APP_NAME') }} Error 404</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #bac5c4;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 156px;
        }

        .not-found {
            font-size: 36px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">404</div>
        <div class="not-found">Page not found</div>
        <div style="font-size: 25px;">
            <br>
            <small>
                Go to <a href='{{ route('home') }}'>homepage</a>
            </small>
        </div>
    </div>
</div>
</body>
</html>
