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
    <body class="body @yield('body-class')">
        <header class="header" id="header">
            <div class="container-fluid container-header-fixed">
                <div class="site-brand">
                    <img src="{{ asset('images/common/logo.png') }}">
                    <span style="max-width: 1000px;">
                        IMC</br>Co., Ltd
                    </span>
                </div>
                @auth
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="">
                            <i class="glyphicon glyphicon-user"></i>
                            {{ Auth::user()->name }}
                            <span class="caret"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="glyphicon glyphicon-log-out"></i>
                            {{ trans('common.btn_logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                @endauth
            </div>
        </header>
        @yield('menu_header')
        <div class="wrapper @if(request()->route()->getPrefix() == '/page') no-sidebar @endif">
            <div class="container-fluid container-body-fixed">
                <!-- @if(request()->route()->getPrefix() != '')
                    <div class="main-sidebar">
                        @include('elements.service_sidebar')
                    </div>
                    <div class="gap"></div>
                @endif -->
                @yield('content')
            </div>
        </div>
        <div id="loading" style="display: none;"><img src="{{asset("/images/common/loading.gif")}}"></div>
        <meta name="BaseUrl" content="{{url('')}}" />
        <footer class="footer">
            <div class="container-fluid text-center">
                <p>Powered by IMC Co., Ltd</p>
            </div>
        </footer>
        <a href="#header" id="go-top">
            <img src="{{ asset('images/common/arrow-top.png') }}">
        </a>
        <script type="text/javascript" src="{{asset("/js/vendor.js")}}"></script>
        @yield('javascript')
        <script>
            var BaseUrl = $('meta[name="BaseUrl"]').attr('content');
        </script>
</body>
</html>
