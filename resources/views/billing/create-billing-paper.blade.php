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
        <h1 class="main-heading">{{__('billing.title')}}</h1>
        <div class="main-summary billing-paper col-md-12">
            <div class="titlle-form-search">
                <h2>{{ __('billing.head_search') }}</h2>
            </div>

            <!--Begin form search-->
            {!!Form::open(['method' => 'GET'])!!}
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
                        <label class="label-control">{{__('billing.lbl_payment_due_date')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="group-datepicker">
                            {!! Form::text('payment_due_date', null, ['class' => 'form-control custom-datepicker', 'placeholder' => __('billing.lbl_payment_due_date'), 'id' => 'payment-due-date']) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_status')}}</label>
                    </div>
                    <div class="right-side">
                        <div class="custom-select">
                            {!! Form::select(0, $model['statusSelector'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_person_name_1')}}</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('ope_name_1', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_person_name_1'), 'id' => 'ope-name-1']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_phone_1')}}</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('ope_phone_1', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_phone_1'), 'id' => 'ope-phone-1']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_email_1')}}</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('ope_email_1', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_email_1'), 'id' => 'ope-email-1']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_person_name_2')}}</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('ope_name_2', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_person_name_2'), 'id' => 'ope-name-2']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_phone_2')}}</label>
                    </div>
                    <div class="right-side">
                        {!! Form::text('ope_phone_2', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_phone_2'), 'id' => 'ope-phone-2']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="left-side">
                        <label class="label-control">{{__('billing.lbl_ope_email_2')}}</label>
                    </div>
                    <div class="right-side">
                         {!! Form::text('ope_email_2', null, ['class' => 'form-control', 'placeholder' => __('billing.lbl_ope_email_2'), 'id' => 'ope-email-2']) !!}
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

            <!--Table company billing-->
            <div id="block-tbl-company">
                <table class="table table-blue table-list-company">
                    <thead>
                        <tr>
                            <th rowspan="2" class="tbl-row-pick"></th>
                            <th rowspan="2" class="tbl-row-no">{{__('billing.tbl_list_company_header.no')}}</th>
                            <th rowspan="2" class="tbl-row-company-name">{{__('billing.tbl_list_company_header.company_name')}}</th>
                            <th rowspan="2" class="tbl-row-date">{{__('billing.tbl_list_company_header.payment_due_date')}}</th>
                            <th rowspan="2" class="tbl-row-method">{{__('billing.tbl_list_company_header.billing_method_name')}}</th>
                            <th colspan="3">{{__('billing.tbl_list_company_header.operation_no')}}</th>
                            <th rowspan="2" class="tbl-row-money">{{__('billing.tbl_list_company_header.ope_total_money')}}</th>
                            <th rowspan="2" class="tbl-row-status">{{__('billing.tbl_list_company_header.status')}}</th>
                            <th rowspan="2" class="tbl-row-approve">{{__('billing.tbl_list_company_header.status_approve')}}</th>
                            <th rowspan="2" class="tbl-row-process"></th>
                        </tr>
                        <tr>
                            <th class="tbl-row-ope-name">{{__('billing.tbl_list_company_header.ope_name')}}</th>
                            <th class="tbl-row-ope-phone">{{__('billing.tbl_list_company_header.ope_phone')}}</th>
                            <th class="tbl-row-ope-email">{{__('billing.tbl_list_company_header.ope_email')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i<25; $i++ )
                            <tr>
                                <td class="tbl-row-pick">
                                    <div class="custom-radio">
                                        <input class="hidden" id="company_id" name="rdo_company" type="radio">
                                        <label for="company_id"></label>
                                    </div>
                                </td>
                                <td class="tbl-row-no">1</td>
                                <td class="tbl-row-company-name">Company 1</td>
                                <td class="tbl-row-date">2018/09/29</td>
                                <td class="tbl-row-method">四半期（船毎/個別押印）</td>
                                <td class="tbl-row-ope-name">Full name 1</td>
                                <td class="tbl-row-ope-phone">0944584584</td>
                                <td class="tbl-row-ope-email">abc123456@gmail.com</td>
                                <td class="tbl-row-money">1.000（円）</td>
                                <td class="tbl-row-status">未発行</td>
                                <td class="tbl-row-approve">承認済み</td>
                                <td class="tbl-row-process">
                                    <a href="{{route('billing.preview.billing.paper')}}" target="_blank" id="btn-pdf">
                                        <i class="glyphicon glyphicon-file"></i>
                                    </a>
                                    <a href="{{route('billing.history.billing')}}"  id="btn-history">
                                        <i class="fa fa-history" aria-hidden="true"></i>
                                    </a>

                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!--Process billing-->
            <div class="create-billing">
                <div class="content-billing">
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_remark')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-select">
                                {!! Form::textarea('remark', null, ['size' => '30x3', 'class' => 'form-control', 'placeholder' => __('billing.lbl_remark'), 'id' => 'remark']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left-side">
                            <label class="label-control">{{__('billing.lbl_is_detail')}}</label>
                        </div>
                        <div class="right-side">
                            <div class="custom-checkbox">
                                <input class="hidden" id="is_detail" name="is_detail" type="checkbox">
                                <label for="is_detail"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="process-billing">
                    <div class="form-group">
                        <div class="right-side">
                             {!! Form::button( __('billing.btn_back'), ["class"=>"btn btn-blue-light btn-w150", 'id' => 'btn-back']) !!}
                             {!! Form::button( __('billing.btn_export_csv'), ["class"=>"btn btn-blue-dark btn-w150", 'id' => 'btn-export-csv']) !!}
                             {!! Form::button( __('billing.btn_create_billing_paper'), ["class"=>"btn btn-green-dark btn-w150", 'id' => 'btn-create-billing']) !!}
                        </div>
                    </div>
                </div>
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

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/create-billing-paper.js') }}"></script>
@endsection