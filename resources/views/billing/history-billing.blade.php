@extends('layouts.white')

@section('title',__('billing.title_history_billing'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/history-billing.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('content')
    <div class="main-content" id="history-billing">
        <h1 class="main-heading">{{__('billing.title_history_billing')}}</h1>
        <div class="main-summary billing-paper col-md-12">
            {{ Form::hidden('domain', url(''), ['id' => 'url-domain']) }}
            <div class="titlle-form-search">
                <h2>{{ __('billing.head_search') }}</h2>
            </div>

            <!--Begin form search-->
            {!!Form::open(['method' => 'GET'])!!}
                <div class="content-form">
                    <div class="form-group mdr-40">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_history_billing_id')}}</label>
                        </div>
                        <div class="right-side">
                          {!! Form::text('history_billing_id', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_history_billing_id'), 'id' => 'history-billing-id']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_company_id')}}</label>
                        </div>
                        <div class="right-side">
                          {!! Form::text('company_id', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_company_id'), 'id' => 'company-id']) !!}
                        </div>
                    </div>
                    <div class="form-group alone">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_company_name')}}</label>
                        </div>
                        <div class="right-side">
                          {!! Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_company_name'), 'id' => 'company-name']) !!}
                        </div>
                    </div>
                    <div class="form-group clear-both mdr-40">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_nation_name')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['nation'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_currency_name')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['currency'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_create_paper_date')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('start_create_paper_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_create_paper_date'), 'id' => 'start-create-paper-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group between">～</div>
                    <div class="form-group">
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('end_create_paper_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_create_paper_date'), 'id' => 'end-create-paper-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_payment_deadline_date')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('start_payment_deadline_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_deadline_date'), 'id' => 'start-payment-deadline-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group between">～</div>
                    <div class="form-group">
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('end_payment_deadline_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_deadline_date'), 'id' => 'end-payment-deadline-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                     <div class="form-group clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_status')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['status'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_payment_actual_date')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('start_payment_actual_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_actual_date'), 'id' => 'start-payment-actual-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group between">～</div>
                    <div class="form-group">
                        <div class="right-side">
                            <div class="group-datepicker">
                                {!! Form::text('end_payment_actual_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_actual_date'), 'id' => 'end-payment-actual-date']) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clear-both">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_total_money')}}</label>
                        </div>
                        <div class="right-side">
                            {!! Form::text('start_total_money', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_total_money'), 'id' => 'start-total-money']) !!}
                        </div>
                    </div>
                    <div class="form-group between">～</div>
                    <div class="form-group">
                        <div class="right-side">
                            {!! Form::text('end_total_money', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_total_money'), 'id' => 'end-total-money']) !!}
                        </div>
                    </div>

                    <div class="form-btn">
                        {!! Form::button( __('billing.btn_back'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-back']) !!}
                        {!! Form::button( __('billing.btn_search'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-search']) !!}
                    </div>
                </div>
            {!! Form::close() !!}

            <!-- Title table -->
            <div class="block-title-tbl">
                <div class="left-side">
                    <label class="label-control">{{__('billing.lbl_count_record_1')}}100{{__('billing.lbl_count_record_2')}}</label>
                </div>
                <div class="right-side">
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_number_record_display')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::select(0, $model['numberRecord'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Table history billing-->
            <div id="block-tbl-history">
                <table class="table table-blue table-history">
                    <thead>
                        <tr>
                            <th class="tbl-row-id">{{__('billing.tbl_history_header.history_billing_id')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-company-name">{{__('billing.tbl_history_header.company_name')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-nation">{{__('billing.tbl_history_header.nation_name')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-create-date">{{__('billing.tbl_history_header.create_paper_date')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-deadline-date">{{__('billing.tbl_history_header.payment_deadline_date')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-actual-date">{{__('billing.tbl_history_header.payment_actual_date')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-money">{{__('billing.tbl_history_header.total_money')}}<i class="fa fa-sort"></i></th>
                            <th class="tbl-row-link">{{__('billing.tbl_history_header.link_pdf')}}</th>
                            <th class="tbl-row-status">{{__('billing.tbl_history_header.status_approve')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tbl-row-id">1</td>
                            <td class="tbl-row-company-name">Company 1</td>
                            <td class="tbl-row-nation">Nation 1</td>
                            <td class="tbl-row-create-date">2018/09/29</td>
                            <td class="tbl-row-deadline-date">2018/09/29</td>
                            <td class="tbl-row-actual-date">
                                <a href="#" class="payment-billing">Update date</a>
                            </td>
                            <td class="tbl-row-money">1.000（円）</td>
                            <td class="tbl-row-link">
                                <a href="#">File pdf billing 1</a>
                            </td>
                            <td class="tbl-row-status">未発行</td>
                        </tr>
                        <tr>
                            <td class="tbl-row-id">1</td>
                            <td class="tbl-row-company-name">Company 1</td>
                            <td class="tbl-row-nation">Nation 1</td>
                            <td class="tbl-row-create-date">2018/09/29</td>
                            <td class="tbl-row-deadline-date">2018/09/29</td>
                             <td class="tbl-row-actual-date">
                                <a href="#" class="payment-billing">Update date</a>
                            </td>
                            <td class="tbl-row-money">1.000（円）</td>
                            <td class="tbl-row-link">
                                <a href="#">File pdf billing 1</a>
                            </td>
                            <td class="tbl-row-status">未発行</td>
                        </tr>
                        @for($i = 0; $i<25; $i++ ) 
                            <tr>
                                <td class="tbl-row-id">1</td>
                                <td class="tbl-row-company-name">Company 1</td>
                                <td class="tbl-row-nation">Nation 1</td>
                                <td class="tbl-row-create-date">2018/09/29</td>
                                <td class="tbl-row-deadline-date">2018/09/29</td>
                                <td class="tbl-row-actual-date">2018/09/29</td>
                                <td class="tbl-row-money">1.000（円）</td>
                                <td class="tbl-row-link">
                                    <a href="#">File pdf billing 1</a>
                                </td>
                                <td class="tbl-row-status">未発行</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 clear-both">
                <nav class="text-center" aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                          <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">
                                1
                                <span class="sr-only">(current)</span>
                            </span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!--Popup update payment billing date-->
    <div class="modal modal-protector fade" id="modal-update-payment-date" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{__('billing.title_popup_update_payment_date')}}</h2>
                </div>
                {!!Form::open(['method' => 'GET'])!!}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="left-side">
                                <label class="label-control">{{__('billing.lbl_history_billing_id')}}</label>
                            </div>
                            <div class="right-side">
                                 <label class="label-control">: {{__('billing.lbl_history_billing_id')}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="left-side">
                                <label class="label-control">{{__('billing.lbl_company_name')}}</label>
                            </div>
                            <div class="right-side">
                                 <label class="label-control">: {{__('billing.lbl_company_name')}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="left-side">
                                <label class="label-control">{{__('billing.lbl_payment_actual_date')}}</label>
                            </div>
                            <div class="right-side">
                                <div class="group-datepicker">
                                    {!! Form::text('payment_actual_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_actual_date'), 'id' => 'payment-actual-date']) !!}
                                    <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn">
                            {!! Form::button( __('billing.btn_cancel'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-cancel', 'data-dismiss' => 'modal']) !!}
                            {!! Form::button( __('billing.btn_update'), ["class"=>"btn btn-orange btn-w150", 'id' => 'btn-update']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/history-billing.js') }}"></script>
@endsection