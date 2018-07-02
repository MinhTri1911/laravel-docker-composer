@extends('layouts.white')
@section('title', __('home-menu.head_title'))
@section('style')
    <link rel="stylesheet" href="{{asset("/css/home-menu.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('content')
    <div class="main-content" id="home-menu">
        <h1 class="main-heading">{{ __('home-menu.head_title') }}</h1>
        <div class="main-summary">
            <div class="menu">
                @isset($mode)
                    @if ($mode == \App\Common\Constant::TYPE_LOGIN_ENTERPRISE)
                        <h2>{{ __('home-menu.lbl_company_selection') }}</h2>
                    @endif
                    @if($mode == \App\Common\Constant::TYPE_LOGIN_SERVICE)
                        <h2>{{ __('home-menu.lbl_service_selection') }}</h2>
                    @endif
                @endisset
               {!!
                Form::open([
                    'method' => 'POST',
                    'route' => (isset($mode)&&$mode<=\App\Common\Constant::TYPE_LOGIN_SERVICE)?'menu.login-service':'menu.logout-service',
                    'id' => 'form_provider'
                ])
               !!}
                    <input type="hidden" name="_mode" value="{{ isset($mode)?$mode:'' }}">
                    <input type="hidden" name="_current" value="{{ isset($current)?$current:'' }}">
                    @if ($mode <= \App\Common\Constant::TYPE_LOGIN_SERVICE )
                    <div class="btn-management center-block">
                        <div class="custom-select">
                            <select class="form-control @if($mode==\App\Common\Constant::TYPE_LOGIN_ENTERPRISE) enterprise @else service @endif" id="provider_list">
                                
                             </select>
                        </div>
                        <a href="{{ route('menu.add-login') }}" class="btn btn-blue-dark btn-switch-login">{{ ($mode==\App\Common\Constant::TYPE_LOGIN_ENTERPRISE)?__('company.btn_select_other_company'):__('company.btn_select_other_service') }}</a>
                        <button type="button" class="btn btn-blue-light btn-logout-provider">{{ __('company.btn_logout') }}</button>
                    </div>
                    @else
                        {{-- User enterprise login to service --}}
                        <div class="btn-management center-block">
                            <button type="button" class="btn btn-blue-light btn-logout-service">{{ __('company.btn_logout') }}</button>
                        </div>

                    @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script type="text/javascript" src="{{ asset('js/menu-home.js') }}"></script>
@endsection