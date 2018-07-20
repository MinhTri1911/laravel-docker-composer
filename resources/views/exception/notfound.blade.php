@extends('layouts.exception')

@section('title', __('exception.notfound.title'))

@section('style')
<link rel="stylesheet" href="{{asset("/css/exception.css")}}">
@endsection

@section('content')
<div class="error-wrap">
    <h3 class="title" style="font-size: 70px !important;">{{ __('exception.notfound.title') }}</h3>
    <h4>{{ $message }}  {{ __('exception.notfound.description_notfound') }}</h4>
    <a href="{{ route('user.list') }}" class="btn btn-lg btn-success bt-back-home-ex">{{ __('exception.404.btn_back_home') }}</a>
</div>
@endsection
