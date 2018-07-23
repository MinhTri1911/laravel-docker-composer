@extends('layouts.white')

@section('title', trans('ship.head_create_ship'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/ship-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-ship')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('ship.head_create_ship') }}</h1>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="main-summary pd-bt-60">

                    <div class="title">
                        <h2>{{ trans('ship.lbl_ship_infomation') }}</h2>
                    </div>

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
                                住所1を入力してください。
                            </label>
                        </div>
                        <div class="block-error">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            <label class="control-label">
                                住所1を入力してください。
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-ship-name">
                                    {{ trans('ship.lbl_title_ship_name') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-name', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_name'),
                                        'tabindex' => 1,
                                        'require' => true,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="slb-company">
                                    {{ trans('ship.lbl_title_company') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-company', [1 => 'AAAA', 2 => 'BBBB', 3 => 'CCCCC'], 1, [
                                        'class' => 'form-control',
                                        'tabindex' => 2,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-imo-number">
                                    {{ trans('ship.lbl_title_imo_number') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-imo-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_imo_number'),
                                        'tabindex' => 3,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-mmsi-number">
                                    {{ trans('ship.lbl_title_mmsi_number') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-mmsi-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_mmsi_number'),
                                        'tabindex' => 4,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="slb-nation">
                                    {{ trans('ship.lbl_title_nation') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-nation', [1 => 'VN', 2 => 'JP', 3 => 'USA'], 1, ['class' => 'form-control', 'tabindex' => 5]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="slb-classification">
                                    {{ trans('ship.lbl_title_classification') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-classification', [0 => 'Please select', 1 => '54', 2 => '123123'], 0, [
                                        'class' => 'form-control',
                                        'tabindex' => 6,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-register-number">
                                    {{ trans('ship.lbl_title_register_number') }}
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::text('txt-register-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_register_number'),
                                        'tabindex' => 7,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-ship-type">
                                    {{ trans('ship.lbl_title_ship_type') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-ship-type', [0 => 'Please select', 1 => '123345', 2 => '123456234'], 0, [
                                        'class' => 'form-control',
                                        'tabindex' => 8,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-ship-length">
                                    {{ trans('ship.lbl_title_ship_length') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-length', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_length'),
                                        'tabindex' => 9,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-ship-width">
                                    {{ trans('ship.lbl_title_ship_width') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-width', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_width'),
                                        'tabindex' => 10,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-water-draft">
                                    {{ trans('ship.lbl_title_water_draft') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-water-draft', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_water_draft'),
                                        'tabindex' => 11,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-total-weight-ton">
                                    {{ trans('ship.lbl_title_total_weight_ton') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-total-weight-ton', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_total_weight_ton'),
                                        'tabindex' => 12,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-weight-ton">
                                    {{ trans('ship.lbl_title_weight_ton') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-weight-ton', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_weight_ton'),
                                        'tabindex' => 13,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-member-number">
                                    {{ trans('ship.lbl_title_member_number') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-member-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_member_number'),
                                        'tabindex' => 14,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-remark">
                                    {{ trans('ship.lbl_title_remark') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::textarea('txt-remark', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_remark'),
                                        'tabindex' => 15,
                                        'rows' => '3',
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-url-1">
                                    {{ trans('ship.lbl_url_1') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-1', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_1'),
                                        'tabindex' => 16,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-url-2">
                                    {{ trans('ship.lbl_url_2') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-2', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_2'),
                                        'tabindex' => 17,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-url-3">
                                    {{ trans('ship.lbl_url_3') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-3', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_3'),
                                        'tabindex' => 18,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 mg-t-20">
                            <div class="block-button">
                                {{ Form::button(trans('ship.btn_create_ship'), [
                                        'class' => 'btn btn-green-dark btn-w150 btn-right',
                                        'tabindex' => 20,
                                    ])
                                }}
                                {{ Form::button(trans('ship.btn_back'), [
                                        'class' => 'btn btn-gray-dark btn-w150 btn-right',
                                        'tabindex' => 19,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
