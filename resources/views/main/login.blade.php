<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="{{asset('css/images/favicon.ico')}}" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="{{asset('css/normalize-2.1.2.css')}}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800,300italic,400italic,800italic,600italic,700italic' rel='stylesheet' type='text/css'>
        <link href="http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Логин</title>
    </head>
    <body>
        <div class="wraper" id="app">
            <auth-widget class="text-xs-right footer-right"></auth-widget>
            <dialog-registration></dialog-registration>
            <dialog-login></dialog-login>
        </div>
        <script src="{{asset('js/app.js')}}" type="application/javascript"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    </body>
</html>