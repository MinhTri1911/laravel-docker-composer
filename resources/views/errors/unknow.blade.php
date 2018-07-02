<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="support" data-url="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset("/css/error/error.css")}}" charset="utf-8">
    
    <!-- Add more css -->
    @yield('style')
</head>
    <body class="a">
        <h2 class="text-center"> エラーコード {{$code ?? null}}</h2>
        <div class="text-center error_lable">
            <label >{{$message ?? null}}</label>
        </div>
        <div class="text-center error-button">
            {!! link_to_route('menu.home', __('error.button_error'), null, ['class' => 'btn btn-custom']) !!}
        </div>
        <footer class="footer">
            <p class="text-center">{{__('error.footer_content')}}</p>
        </footer>
    </body>
</html>