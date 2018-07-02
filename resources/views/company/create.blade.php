@extends('layouts.white')

@section('title', trans('company.title_head_create_company'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/company-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-company')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('company.title_head_create_company') }}</h1>

        <div class="main-summary">
            <div class="titlle-form-search">
                <h2>{{ trans('company.lbl_title_company_infomation') }}</h2>
            </div>
            <!-- begin alert errors -->
            <div class="alert alert-danger">
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        住所1を入力してください。
                    </label>
                </div>
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        電話番号を入力してください。
                    </label>
                </div>
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        秘密の質問を入力してください。
                    </label>
                </div>
            </div>
            <!-- end alert errors -->
            <!-- begin form input company infomation -->
            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-name-jp">
                            {{ trans('company.lbl_title_company_name_jp') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-name-jp', '', [
                                'class' => 'form-control',
                                'tabindex' => 1,
                                'require' => true,
                                'placeholder' => trans('company.lbl_title_company_name_jp'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-name-en">
                            {{ trans('company.lbl_title_company_name_en') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-name-en', '', [
                                'class' => 'form-control',
                                'tabindex' => 2,
                                'require' => true,
                                'placeholder' => trans('company.lbl_title_company_name_en'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-nation">
                            {{ trans('company.lbl_title_company_nation') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-nation', [
                                    1 => 'VN',
                                    2 => 'JP',
                                    3 => 'USA',
                                ], 1, ['class' => 'form-control', 'tabindex' => 3,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-postal-code">
                            {{ trans('company.lbl_title_company_postal_code') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-postal-code', '', [
                                'class' => 'form-control',
                                'tabindex' => 4,
                                'placeholder' => trans('company.lbl_title_company_postal_code'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-address">
                            {{ trans('company.lbl_title_company_address') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-address', '', [
                                'class' => 'form-control',
                                'tabindex' => 5,
                                'placeholder' => trans('company.lbl_title_company_address')
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-represent-person">
                            {{ trans('company.lbl_title_company_represent_person') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-represent-person', '', [
                                'class' => 'form-control',
                                'tabindex' => 6,
                                'require' => true,
                                'placeholder' => trans('company.lbl_title_company_represent_person'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-fund">
                            {{ trans('company.lbl_title_company_fund') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-fund', '', [
                                'class' => 'form-control',
                                'tabindex' => 7,
                                'placeholder' => trans('company.lbl_title_company_fund'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-company-currency">
                            {{ trans('company.lbl_title_company_currency') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-company-currency', [
                                    1 => 'VND',
                                    2 => 'JP',
                                    3 => 'USD',
                                ], 1, ['class' => 'form-control', 'tabindex' => 8,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-employee-number">
                            {{ trans('company.lbl_title_company_employee_number') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-employee-number', '', [
                                'class' => 'form-control',
                                'tabindex' => 9,
                                'placeholder' => trans('company.lbl_title_company_employee_number'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-year-reseach">
                            {{ trans('company.lbl_title_company_year_research') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-year-reseach', '', [
                                'class' => 'form-control',
                                'tabindex' => 10,
                                'placeholder' => trans('company.lbl_title_company_employee_number'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-company-billing-method">
                            {{ trans('company.lbl_title_company_billing_method') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-company-billing-method', [
                                    1 => 'ALL',
                                    2 => 'ONE',
                                ], 1, ['class' => 'form-control', 'tabindex' => 11,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-company-month-billing">
                            {{ trans('company.lbl_title_company_month_billing') }}
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-company-month-billing[]', [
                                1 => trans('company.slb_month') . '1',
                                2 => trans('company.slb_month') . '2',
                                3 => trans('company.slb_month') . '3',
                                4 => trans('company.slb_month') . '4',
                                5 => trans('company.slb_month') . '5',
                                6 => trans('company.slb_month') . '6',
                                7 => trans('company.slb_month') . '7',
                                8 => trans('company.slb_month') . '8',
                                9 => trans('company.slb_month') . '9',
                                10 => trans('company.slb_month') . '10',
                                11 => trans('company.slb_month') . '11',
                                12 => trans('company.slb_month') . '12',
                            ], null, [
                                'class' => 'form-control',
                                'tabindex' => 12,
                                'multiple' => 'multiple',
                                'data-placeholder' => 'Yours Placeholder',
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-payment-deadline-no">
                            {{ trans('company.lbl_title_company_payment_deadline_no') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-payment-deadline-no', '', [
                                'class' => 'form-control',
                                'tabindex' => 13,
                                'placeholder' => trans('company.lbl_title_company_payment_deadline_no'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-site">
                            {{ trans('company.lbl_title_company_site') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-site', '', [
                                'class' => 'form-control',
                                'tabindex' => 14,
                                'placeholder' => trans('company.lbl_title_company_site'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-currency-code">
                            {{ trans('company.lbl_title_company_currency_code') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-currency-code', '', [
                                'class' => 'form-control',
                                'tabindex' => 15,
                                'placeholder' => trans('company.lbl_title_company_currency_code'),
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-company-operation">
                            {{ trans('company.lbl_title_company_operation') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-company-operation', [
                                1 => 'IMC',
                                2 => 'BMC',
                                3 => 'DMC'
                            ], 1, [
                                'class' => 'form-control',
                                'tabindex' => 16,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-company-url">
                            {{ trans('company.lbl_title_company_url') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-company-url', '', [
                                'class' => 'form-control',
                                'tabindex' => 17,
                                'placeholder' => trans('company.lbl_title_company_url'),
                            ])
                        }}
                    </div>
                </div>
            </div>
            <!-- end form input company infomation -->
            <!-- begin form input operation person 1 -->
            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label>
                            {{ trans('company.lbl_company_ope_person_1') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-name-1">
                            {{ trans('company.lbl_title_ope_name') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-name-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 18,
                                'placeholder' => trans('company.lbl_title_ope_name'),
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-position-1">
                            {{ trans('company.lbl_title_ope_position') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-position-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 19,
                                'placeholder' => trans('company.lbl_title_ope_position'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-department-1">
                            {{ trans('company.lbl_title_ope_department') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-department-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 20,
                                'placeholder' => trans('company.lbl_title_ope_department'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-postal-code-1">
                            {{ trans('company.lbl_title_ope_postal_code') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-postal-code-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 21,
                                'placeholder' => trans('company.lbl_title_ope_postal_code'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-address-1">
                            {{ trans('company.lbl_title_ope_address') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-address-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 22,
                                'placeholder' => trans('company.lbl_title_ope_address'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-phone-1">
                            {{ trans('company.lbl_title_ope_phone') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-phone-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 23,
                                'placeholder' => trans('company.lbl_title_ope_phone'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-fax-1">
                            {{ trans('company.lbl_title_ope_fax') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-fax-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 24,
                                'placeholder' => trans('company.lbl_title_ope_fax'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-email-1">
                            {{ trans('company.lbl_title_ope_email') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-email-1', '', [
                                'class' => 'form-control',
                                'tabindex' => 25,
                                'placeholder' => trans('company.lbl_title_ope_email'),
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>
            </div>
            <!-- end form input operation person 1 -->
            <!-- begin form input operation person 2 -->
            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label>
                            {{ trans('company.lbl_company_ope_person_2') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-name-2">
                            {{ trans('company.lbl_title_ope_name') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-name-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 26,
                                'placeholder' => trans('company.lbl_title_ope_name'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-position-2">
                            {{ trans('company.lbl_title_ope_position') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-position-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 27,
                                'placeholder' => trans('company.lbl_title_ope_position'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-department-2">
                            {{ trans('company.lbl_title_ope_department') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-department-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 28,
                                'placeholder' => trans('company.lbl_title_ope_department'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-postal-code-2">
                            {{ trans('company.lbl_title_ope_postal_code') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-postal-code-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 29,
                                'placeholder' => trans('company.lbl_title_ope_postal_code'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-address-2">
                            {{ trans('company.lbl_title_ope_address') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-address-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 30,
                                'placeholder' => trans('company.lbl_title_ope_address'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-phone-2">
                            {{ trans('company.lbl_title_ope_phone') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-phone-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 31,
                                'placeholder' => trans('company.lbl_title_ope_phone'),
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-fax-2">
                            {{ trans('company.lbl_title_ope_fax') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-fax-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 32,
                                'placeholder' => trans('company.lbl_title_ope_fax'),
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ope-email-2">
                            {{ trans('company.lbl_title_ope_email') }}
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ope-email-2', '', [
                                'class' => 'form-control',
                                'tabindex' => 33,
                                'placeholder' => trans('company.lbl_title_ope_email'),
                            ])
                        }}
                    </div>
                </div>
            </div>
            <!-- end form input operation person 1 -->
            <!-- begin form input ship information -->
            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label>
                            {{ trans('company.lbl_title_ship_infomation') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ship-name">
                            {{ trans('ship.lbl_title_ship_name') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ship-name', '本社（英文名：Headquarters)', [
                                'class' => 'form-control',
                                'tabindex' => 34,
                                'placeholder' => trans('ship.lbl_title_ship_name'),
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="txt-ship-imo-number">
                            {{ trans('ship.lbl_title_imo_number') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input">
                        {{ Form::text('txt-ship-imo-number', '0', [
                                'class' => 'form-control',
                                'tabindex' => 35,
                                'placeholder' => trans('ship.lbl_title_imo_number'),
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-ship-nation">
                            {{ trans('ship.lbl_title_nation') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-ship-nation', [
                                1 => 'VN',
                                2 => 'JP',
                                3 => 'USA',
                            ], 1, [
                                'class' => 'form-control',
                                'tabindex' => 36,
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>

                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-ship-classification">
                            {{ trans('ship.lbl_title_classification') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-ship-classification', [
                                1 => 'Cap 1',
                                2 => 'Cap 2',
                                3 => 'Cap 3',
                                4 => 'Cap 4',
                            ], 1, [
                                'class' => 'form-control',
                                'tabindex' => 37,
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 block-input">
                    <div class="lbl-title">
                        <label for="slb-ship-type">
                            {{ trans('ship.lbl_title_ship_type') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="form-input custom-select">
                        {{ Form::select('slb-ship-type', [
                                1 => 'Type 1',
                                2 => 'Type 2',
                                3 => 'Type 3',
                            ], 1, [
                                'class' => 'form-control',
                                'tabindex' => 38,
                                'require' => true,
                            ])
                        }}
                    </div>
                </div>
            </div>
            <!-- end form input ship information -->

            <div class="row">
                <div class="col-md-12 block-button">
                    {{ Form::button(trans('company.btn_create_company'), ['class' => 'btn btn-green-dark btn-w150', 'tabindex' => 40]) }}
                    {{ Form::button(trans('company.btn_back_to_list'), ['class' => 'btn btn-gray-dark btn-w150', 'tabindex' => 39]) }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <!-- <script type="text/javascript" src="{{ asset('js/company-general-list-company.js') }}"></script> -->
@endsection
