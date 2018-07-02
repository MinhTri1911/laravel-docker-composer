@extends('layouts.login')


@section('title',__('auth.head_company_login'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/auth.css")}}">
@endsection

@section('content')
    <div class="container-login">
        <div class="display-error"></div> 
        {{ Form::open(['route' => 'auth.company-login', 'novalidate' => 'novalidate','id' => 'form-login']) }}
        <div class="form-group">
            {{ Form::label('text', __('auth.lbl_company_id')) }}
            {{ Form::text('type_cd',null,['class' => 'form-control', 'id' => 'type_cd','autofocus' => 'autofocus', 'maxlength' => '64']) }}
        </div>
        <div class="form-group">
            {{ Form::label('text', __('auth.lbl_login_id')) }}
            {{ Form::text('login_id',null,['class' => 'form-control', 'id' => 'login_id', 'maxlength' => '64']) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', __('auth.lbl_password')) }}
            {{ Form::password('password',['class' => 'form-control', 'id' => 'password']) }}
        </div>
        <button type="button" id="btn-login" class="center-block btn btn-blue-dark btn-w190">{{ __('auth.btn_login') }}</button>
        {{ Form::close() }}
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/auth-company.js') }}"></script>
@endsection