@extends('layouts.white')

@section('title',__('approve.title_approve'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/approve.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'approve')

@section('content')
<div class="main-content">
    <h1 class="main-heading">{{__('approve.header_approve')}}</h1>
    <div class="main-summary approve-list">
        <div class="search-block">
            {!!
                Form::open([
                    'method' => 'GET',
                    'route' => ['approve.list']
                ])
            !!}
            <div class="content-block table-block">
                <div class="item-row date-group">
                    <div class="item-label">
                        {{__('approve.lbl_date_create')}}
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('date_from', null, ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                        <span class="split-a">~</span>
                        <div class="group-datepicker">
                            {!! Form::text('date_to', null, ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('approve.lbl_creator')}}
                    </div>
                    <div class="item-value">
                        {!! Form::text('sender', null, ['class' => 'form-control', 'placeholder' =>  __('approve.lbl_creator')]) !!}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('approve.lbl_type')}}
                    </div>
                    <div class="item-value form-inline">
                        <div class="form-group">
                            <div class="custom-select">
                             {!! Form::select('setting_type', \App\Common\Constant::TYPE_APPROVE, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group form-group-right">
                            <div class="item-label">
                                {{__('approve.lbl_status')}}
                            </div>
                            <div class="item-value">
                                <div class="custom-select">
                                     {!! Form::select('setting_status', array_slice( \App\Common\Constant::APPROVED_O, 1, 2, true), null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-handle align-center">
                <button class="btn btn-orange btn-w150">{{__('approve.btn_search')}}</button>
            </div>
            {!!Form::close()!!}
        </div>
        {{-- List contract --}}
        <div class="result-app-block contract-block content-load">
            @if(isset($datas))
                @if(request()->filled('setting_type') && request()->get('setting_type') == \App\Business\ApproveBusiness::TYPE_APPROVE_SPOT)
                    @include('approve.list-spot', ['datas' => $datas])
                @elseif(request()->filled('setting_type') && request()->get('setting_type') == App\Business\ApproveBusiness::TYPE_APPROVE_BILLING)
                    @include('approve.list-billing', ['datas' => $datas])
                @else
                    @include('approve.list-contract', ['datas' => $datas])
                @endif
            @endif
        </div>
        {{-- End List contract --}}
    </div>
</div>
{{-- Popup --}}
<div class="modal fade modal-service" id="modal-detail">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            hihi
        </div>
    </div>
</div>
{{-- End Popup --}}
{{-- Popup --}}
<div class="modal fade modal-confirm" id="modal-confirm">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('approve.header_pop_approve')}}</h4>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    {{__('approve.msg_pop_approve_contract')}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w150 btn-ok">{{__('approve.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- End Popup --}}
{{-- Popup --}}
<div class="modal fade" id="modal-alert">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('approve.header_pop_approve')}}</h4>
            </div>
            <div class="modal-body">
                <div class="modal-message">
                    Message
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-dark btn-w150" data-dismiss="modal"> {{__('approve.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- End Popup --}}
@endsection

@section('javascript')

<script type="text/javascript">
    var Approve = {
        modalCommon: {
            title_approve: "{{__('approve.header_pop_approve')}}",
            title_reject: "{{__('approve.header_pop_reject')}}",
            message_error_require: "{{__('approve.msg_error_uncheck')}}"
        },
        
        modalContract: {
            title_approve: "{{__('approve.header_pop_approve')}}",
            message_confirm_approve: "{{__('approve.msg_pop_approve_contract')}}",
            
            title_reject: "{{__('approve.header_pop_reject')}}",
            message_confirm_reject: "{{__('approve.msg_pop_reject_contract')}}",
        },
        
        modalSpot: {
            title_approve: "{{__('approve.header_pop_approve')}}",
            message_confirm_approve: "{{__('approve.msg_pop_approve_spot')}}",
            
            title_reject: "{{__('approve.header_pop_reject')}}",
            message_confirm_reject: "{{__('approve.msg_pop_reject_spot')}}",
        },
        
        modalBilling: {
            title_approve: "{{__('approve.header_pop_approve')}}",
            message_confirm_approve: "{{__('approve.msg_pop_approve_billing')}}",
            
            title_reject: "{{__('approve.header_pop_reject')}}",
            message_confirm_reject: "{{__('approve.msg_pop_reject_billing')}}",
        }
    };
</script>
<script type="text/javascript" src="{{ asset('js/approve.js') }}"></script>
@endsection