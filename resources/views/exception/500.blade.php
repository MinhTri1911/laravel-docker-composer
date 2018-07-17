@extends('layouts.exception')

@section('title', __('exception.500.title'))

@section('style')
<link rel="stylesheet" href="{{asset("/css/exception.css")}}">
@endsection

@section('content')
<div class="error-wrap">
    <h1 class="title">{{ __('exception.500.title') }}</h1>
    <h4>{{ $message }} {{ __('exception.500.description_internal_server_error') }}</h4>
    <a href="{{ route('user.list') }}" class="btn btn-lg btn-success bt-back-home-ex">{{ __('exception.500.btn_back_home') }}</a>
</div>
@endsection