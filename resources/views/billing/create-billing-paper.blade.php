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

            <!--Begin form search-->
            {!!Form::open(['method' => 'GET'])!!}

            <!-- Url Search-->
            {{ Form::hidden('url-search', route('billing.search.billing.paper'), ['id' => 'url-search']) }}

                <div class="content-form">
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_company_name')}}</label>
                        </div>
                        <div class="right-side">
                          {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_company_name'), 'id' => 'company-name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_status')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['statusSelector'], null, ['class' => 'form-control', 'id' => 'slt-status']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_status_approve')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['statusApproveSelector'], null, ['class' => 'form-control', 'id' => 'slt-approve']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group alone clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_payment_due_date')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select year">
                                {!! Form::selectRange("start_year", $model['year']['start'], $model['year']['end'], date('Y'), ['class' => 'year single', 'id' => "slt-start-year"]) !!}
                            </div>
                            <span class="pull-left">{{__('billing.lbl_year')}}</span>
                            <div class="custom-select month">
                                {!! Form::selectRange("start_month", 1, 12, (integer)date('m'), ['class' => 'month single', 'id' => "slt-start-month"]) !!}
                            </div>
                            <span class="pull-left">{{__('billing.lbl_month')}}</span>
                            <div class="between f-left">～</div>
                            <div class="custom-select year">
                                {!! Form::selectRange("end_year", $model['year']['start'], $model['year']['end'], date('Y'), ['class' => 'year single', 'id' => "slt-end-year"]) !!}
                            </div>
                            <span class="pull-left">{{__('billing.lbl_year')}}</span>

                            <div class="custom-select month">
                                {!! Form::selectRange("end_month", 1, 12, (integer)date('m'), ['class' => 'month single', 'id' => "slt-end-month"]) !!}
                            </div>
                            <span class="pull-left">{{__('billing.lbl_month')}}</span>
                        </div>
                    </div>
                    <div class="form-btn">
                         {!! Form::button( __('billing.btn_search'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-search']) !!}
                    </div>
                </div>
            {!! Form::close() !!}

            <!-- Title table -->
            <div class="block-title-tbl">
                <div class="left-side">
                    <label class="label-control">{{__('billing.lbl_count_record_1') . $model['resultSearch']->total() . __('billing.lbl_count_record_2')}}</label>
                </div>
                <div class="right-side">
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_number_record_display')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['numberRecord'], null, ['class' => 'form-control', 'id' => 'slt-number-record']) !!}
                            </div>
                        </div>
                    </div>
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
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{__('billing.title_popup_reason_reject')}}</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id='popup-reason-reject-text' class="label-control">{{__('billing.title_popup_reason_reject')}}</label>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_Ok'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-Ok', 'data-dismiss' => 'modal']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/create-billing-paper.js') }}"></script>
@endsection