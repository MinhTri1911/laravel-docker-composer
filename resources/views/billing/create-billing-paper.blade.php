@extends('layouts.white')

@section('title',__('billing.title_create_billing_paper'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/create-billing-paper.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('content')
    <div class="main-content" id="create-billing-paper">
        <h1 class="main-heading">{{__('billing.title_create_billing_paper')}}</h1>
        <div class="main-summary billing-paper col-md-12">
            <div class="titlle-form-search">
                <h2>{{ __('billing.head_search') }}</h2>
            </div>

            <!-- Url Search-->
            {{ Form::hidden('url_search', route('billing.search.billing.paper'), ['id' => 'url-search']) }}
            {{ Form::hidden('url_create', route('billing.create.billing.paper'), ['id' => 'url-create']) }}
            {{ Form::hidden('url_delivery', route('billing.delivery.billing.paper'), ['id' => 'url-delivery']) }}
            {{ Form::hidden('url_export_csv', route('billing.export.billing.paper'), ['id' => 'url-export-csv']) }}
            <!--User login operate company id-->
            {{ Form::hidden('login_ope_company_id', auth()->user()->ope_company_id, ['id' => 'login-ope-company-id']) }}
            <!--User login operate company id-->
            {{ Form::hidden('login_auth_operation', auth()->user()->auth_operation, ['id' => 'login-auth-operation']) }}

            <div class="content-form">
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_company_name')}}</label>
                    </div>
                    <div class="right-side">
                      {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_company_name'), 'id' => 'company-name', 'tabindex' => 1]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_status')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="custom-select">
                            {!! Form::select(0, $model['statusSelector'], null, ['class' => 'form-control', 'id' => 'slt-status', 'tabindex' => 2]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_status_approve')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="custom-select">
                            {!! Form::select(0, $model['statusApproveSelector'], null, ['class' => 'form-control', 'id' => 'slt-approve', 'tabindex' => 3]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group alone clear-both">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_payment_due_date')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="custom-select year">
                            {!! Form::selectRange("start_year", $model['year']['start'], $model['year']['end'], date('Y'), ['class' => 'year single', 'id' => "slt-start-year", 'tabindex' => 4]) !!}
                        </div>
                        <span class="pull-left">{{__('billing.lbl_year')}}</span>
                        <div class="custom-select month">
                            {!! Form::selectRange("start_month", 1, 12, (integer)date('m'), ['class' => 'month single', 'id' => "slt-start-month", 'tabindex' => 5]) !!}
                        </div>
                        <span class="pull-left">{{__('billing.lbl_month')}}</span>
                        <div class="between f-left">～</div>
                        <div class="custom-select year">
                            {!! Form::selectRange("end_year", $model['year']['start'], $model['year']['end'], date('Y'), ['class' => 'year single', 'id' => "slt-end-year", 'tabindex' => 6]) !!}
                        </div>
                        <span class="pull-left">{{__('billing.lbl_year')}}</span>

                        <div class="custom-select month">
                            {!! Form::selectRange("end_month", 1, 12, (integer)date('m'), ['class' => 'month single', 'id' => "slt-end-month", 'tabindex' => 7]) !!}
                        </div>
                        <span class="pull-left">{{__('billing.lbl_month')}}</span>
                    </div>
                </div>
                <div class="form-btn">
                     {!! Form::button( __('billing.btn_search'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-search', 'tabindex' => 8]) !!}
                </div>
            </div>

            <div id='area-tbl-result'>
                @include('billing.component.table.billing-paper')
            </div>
        </div>
    </div>

    <!--Popup show reason reject-->
    <div class="modal modal-protector fade" id="modal-reason-reject" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{__('billing.lbl_close_popup')}}</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{__('billing.title_popup_reason_reject')}}</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id='popup-reason-reject-text' class="label-control"></label>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_Ok'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-Ok', 'data-dismiss' => 'modal']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Popup alert error-->
    <div class="modal modal-protector fade" id="modal-inform" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{__('billing.lbl_close_popup')}}</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2 id='title-popup-inform'></h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id='popup-inform-message' class="label-control"></label>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_Ok'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-Ok', 'data-dismiss' => 'modal']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Popup Confirm-->
    <div class="modal modal-protector fade" id="modal-confirm" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{__('billing.lbl_close_popup')}}</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2 id='title-popup-confirm'></h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id='popup-confirm-text' class="label-control"></label>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_cancel'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-confirm-cancel', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button( __('billing.btn_Ok'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-confirm-ok']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        var message = {
            'msg_confirm_delivery_again' : "{{__('billing.message.confirm_delivery_again')}}",
            'popup_confirm_delivery_title' : "{{__('billing.title_popup_delivery')}}",
            'export_file_name' : "{{__('billing.export_file_name')}}",
        };
    </script>
    <script type="text/javascript" src="{{ asset('js/create-billing-paper.js') }}"></script>
@endsection