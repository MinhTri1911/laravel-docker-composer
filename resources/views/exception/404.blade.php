@extends('layouts.exception')

@section('title', __('exception.404.title'))

@section('style')
<link rel="stylesheet" href="{{asset("/css/exception.css")}}">
@endsection

@section('content')
<div class="error-wrap">
    <h1 class="title">{{ __('exception.404.title') }}</h1>
    <h4>{{ __('exception.404.description_page_not_found') }}</h4>
    <a href="{{ route('user.list') }}" class="btn btn-lg btn-success bt-back-home-ex">{{ __('exception.404.btn_back_home') }}</a>
</div>
@endsection