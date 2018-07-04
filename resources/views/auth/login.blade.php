@extends('layouts.login')

@section('title',__('auth.head_service_login'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/auth.css")}}">
@endsection

@section('content')
    <div class="service-login">
        <div class="title-page">
            {{ __('auth.title_login') }}
        </div>
        @if ($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        {{ $error }}
                    </label>
                </div>
            @endforeach
        </div> 
        @endif
        {{ Form::open(['route' => 'login', 'novalidate' => 'novalidate', 'id' => 'form-login']) }}
        <div class="form-group{{ $errors->has('login_id') ? ' has-error' : '' }}">
            {{ Form::label('text', __('auth.lbl_login_id'), ['class' => $errors->has('login_id') ? 'label-error' : '']) }}
            {{ Form::text('login_id', null, ['placeholder' => __('auth.lbl_login_id'), 'class' => 'form-control', 'id' => 'login_id', 'maxlength' => '64']) }}
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {{ Form::label('password', __('auth.lbl_password'), ['class' => $errors->has('password') ? 'label-error' : '']) }}
            {{ Form::password('password', ['placeholder' => __('auth.lbl_password'), 'class' => 'form-control', 'id' => 'password']) }}
        </div>
        <div class="login-group-btn">
            <button type="reset" class="btn btn-blue-light btn-w150">{{ __('auth.btn_reset') }}</button>
            <button type="submit" id="btn-login" class="btn btn-blue-dark btn-w150">{{ __('auth.btn_login') }}</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection