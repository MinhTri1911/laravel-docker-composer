<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset("favicons/admin.ico") }}">
    <link rel="icon" type="image/png" href="{{ asset("favicons/admin_48x48.png") }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ asset("favicons/admin_32x32.png") }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset("favicons/admin_16x16.png") }}" sizes="16x16">
    <link rel="stylesheet" href="{{ asset("/css/vendor.css") }}">
    <!-- Add more css -->
    @yield('style')
</head>
<body class="login-layout @yield('body-class')">

    <div class="login-wrapper">@yield('content')</div>

    <script type="text/javascript" src="{{asset("/js/vendor.js")}}"></script>
    @yield('javascript')
</body>
</html>