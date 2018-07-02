@extends('layouts.white')

@section('title', trans('company.title_head_create_company'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/spot.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-spot')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('spot.title_heade_create_spot') }}</h1>

        <div class="main-summary">
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
            <!-- begin form input ship spot infomation -->
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>{{ trans('spot.lbl_ship_spot_id') }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>{{ trans('spot.icon_content') }} 123</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>{{ trans('spot.lbl_ship_name') }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>{{ trans('spot.icon_content') }} Ship A</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>
                            {{ trans('spot.lbl_spot_name') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="col-md-6 custom-select">
                        {{ Form::select('spot-id', [1 => 'Spot 1', 2 => 'Spot 2'], 1, [
                                'class' => 'form-control',
                                'tabindex' => 1,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>
                            {{ trans('spot.lbl_spot_month_usage') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="group-datepicker">
                            {{ Form::text('month-usage', '2018/06/29', [
                                    'class' => 'form-control custom-datepicker',
                                    'placeholder' => trans('spot.format_date'),
                                    'tabindex' => 2,
                                ])
                            }}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>
                            {{ trans('spot.lbl_spot_amount_charge') }}
                            <span class="require">*</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        {{ Form::text('amount-charge', '100000', [
                                'class' => 'form-control',
                                'placeholder' => trans('spot.lbl_spot_amount_charge'),
                                'tabindex' => 3,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>{{ trans('spot.lbl_spot_currency') }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>{{ trans('spot.icon_content') }} USD</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3">
                        <label>{{ trans('spot.lbl_spot_remark') }}</label>
                    </div>
                    <div class="col-md-8">
                        {{ Form::textarea('remark', 'Demo', [
                                'class' => 'form-control',
                                'placeholder' => trans('company.lbl_contract_start_date'),
                                'rows' => 3,
                                'tabindex' => 4,
                            ])
                        }}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-3"></div>
                    <div class="col-md-11 block-button">
                        {{ Form::button(trans('spot.btn_create_spot'), [
                                'class' => 'btn btn-blue-dark btn-w150',
                                'tabindex' => 6,
                            ])
                        }}
                        {{ Form::button(trans('spot.btn_back'), [
                                'class' => 'btn btn-gray btn-w150',
                                'tabindex' => 5,
                            ])
                        }}
                    </div>
                </div>
            </div>
            <!-- end form input ship spot infomation -->
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/datetimepicker-general.js') }}"></script>
    <script type="text/javascript">
        $('.custom-datepicker').datepicker({
            dateFormat: "yy/mm/dd"
        });
    </script>
@endsection
