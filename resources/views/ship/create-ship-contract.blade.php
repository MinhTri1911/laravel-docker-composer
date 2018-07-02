@extends('layouts.white')

@section('title', trans('ship.head_create_ship_contract'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/ship-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-ship-contract')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('ship.head_create_ship_contract') }}</h1>

        <div class="main-summary">
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
                <!-- begin block form left -->
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-ship-name">
                                {{ trans('ship.lbl_title_ship_name') }}
                                <span class="require">*</span>
                                {{ trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="slb-company">
                                {{ trans('ship.lbl_title_company') }}
                                <span class="require">*</span>
                                {{ trans('ship.icon_title') }}
                            </label>
                        </div>
                        <div class="col-md-8 custom-select">
                            <!-- <label class="lbl-title">
                                Company A
                            </label> -->
                            {{ Form::select('slb-company', [1 => 'Company A', 2 => 'Company B'], 2, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-imo-number">
                                {{ trans('ship.lbl_title_imo_number') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-mmsi-number">
                                {{ trans('ship.lbl_title_mmsi_number') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="slb-nation">
                                {{ trans('ship.lbl_title_nation') }}
                                <span class="require">*</span>
                                {{ trans('ship.icon_title') }}
                            </label>
                        </div>
                        <div class="col-md-8 custom-select">
                            {{ Form::select('slb-nation', [1 => 'VN', 2 => 'JP', 3 => 'USA'], 1, ['class' => 'form-control', 'tabindex' => 5]) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="slb-classification">
                                {{ trans('ship.lbl_title_classification') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-register-number">
                                {{ trans('ship.lbl_title_register_number') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-ship-type">
                                {{ trans('ship.lbl_title_ship_type') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-ship-width">
                                {{ trans('ship.lbl_title_ship_width') . trans('ship.icon_title') }}
                            </label>
                        </div>
                        <div class="col-md-8">
                            {{ Form::text('txt-ship-width', '', [
                                    'class' => 'form-control',
                                    'placeholder' => trans('ship.lbl_title_ship_width'),
                                    'tabindex' => 9,
                                ])
                            }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-ship-length">
                                {{ trans('ship.lbl_title_ship_length') . trans('ship.icon_title') }}
                            </label>
                        </div>
                        <div class="col-md-8">
                            {{ Form::text('txt-ship-length', '', [
                                    'class' => 'form-control',
                                    'placeholder' => trans('ship.lbl_title_ship_length'),
                                    'tabindex' => 10,
                                ])
                            }}
                        </div>
                    </div>
                </div>
                <!-- end block form left -->
                <!-- begin block form right -->
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-water-draft">
                                {{ trans('ship.lbl_title_water_draft') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-total-weight-ton">
                                {{ trans('ship.lbl_title_total_weight_ton') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-weight-ton">
                                {{ trans('ship.lbl_title_weight_ton') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-member-number">
                                {{ trans('ship.lbl_title_member_number') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-remark">
                                {{ trans('ship.lbl_title_remark') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-url-1">
                                {{ trans('ship.lbl_url_1') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-url-2">
                                {{ trans('ship.lbl_url_2') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4">
                            <label for="txt-url-3">
                                {{ trans('ship.lbl_url_3') . trans('ship.icon_title') }}
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

                    <div class="col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            {{ Form::button(trans('ship.btn_add_service'), [
                                    'class' => 'btn btn-blue-dark form-control',
                                    'id' => 'btn-add-service',
                                    'data-toggle' =>'modal',
                                    'data-target' => '#popup-add-service',
                                ])
                            }}
                        </div>
                    </div>
                </div>
                <!-- end block form right -->
            </div>

            <div class="row">

            </div>

            <div class="col-md-12">
                <div class="col-md-2">
                    <p class="title">{{ trans('ship.lbl_service_added') }}</p>
                </div>
            </div>

            <!-- begin table show add service -->
            <div class="col-md-12">
                <div class="col-md-12">
                    <table class="table table-blue table-fixed">
                        <thead>
                            <tr>
                                <th class="col-md-2">{{ trans('ship.lbl_head_service_id') }}</th>
                                <th class="col-md-2">{{ trans('ship.lbl_head_service_name') }}</th>
                                <th class="col-md-2">{{ trans('ship.lbl_head_version') }}</th>
                                <th class="col-md-2">{{ trans('ship.lbl_head_price') }}</th>
                                <th class="col-md-2">{{ trans('ship.lbl_head_start_date') }}</th>
                                <th class="col-md-2">{{ trans('ship.lbl_head_end_date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-scroll">
                            @for($i = 1; $i <= 20; $i++)
                                <tr>
                                    <td class="col-md-2">{{ $i }}</td>
                                    <td class="col-md-2">PMA System</td>
                                    <td class="col-md-2">1.0</td>
                                    <td class="col-md-2">20000</td>
                                    <td class="col-md-2">2018/03/29</td>
                                    <td class="col-md-2">2019/03/29</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end table show add service -->

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 block-button">
                        {{ Form::button(trans('ship.btn_add_ship'), ['class' => 'btn btn-green-dark btn-w150 btn-right']) }}
                        {{ Form::button(trans('ship.btn_cancel'), ['class' => 'btn btn-gray btn-w150 btn-right']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-protector modal-normal fade" id="popup-add-service" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-close">
            <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
            <label>閉じる</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{ trans('ship.lbl_head_add_service') }}</h2>
                </div>
                <div class="modal-body">
                    <div>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label for="slb-service">{{ trans('ship.lbl_service_name') }}
                                        <span class="require">*</span>
                                        {{ trans('ship.icon_title') }}
                                    </label>
                                </div>
                                <div class="col-md-6 custom-select">
                                    {{ Form::select('slb-service', [ 1 => 'A', 2 => 'B', 3 => 'C'], 1, [
                                            'class' => 'form-control',
                                        ])
                                    }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_service_version') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl-title">1.0</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_service_price') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl-title">100000</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_start_date') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-datepicker">
                                        {{ Form::text('service-start-date', null, [
                                                'class' => 'form-control custom-datepicker',
                                                'id' => 'datetime',
                                                'placeholder' => trans('ship.lbl_start_date'),
                                            ])
                                        }}
                                        <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_end_date') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-datepicker">
                                        {{ Form::text('service-end-date', null, [
                                                'class' => 'form-control custom-datepicker',
                                                'id' => 'datetime',
                                                'placeholder' => trans('ship.lbl_end_date'),
                                            ])
                                        }}
                                        <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label for="txt-remark">{{ trans('ship.lbl_contract_remark') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::textarea('txt-remark', '', ['class' => 'form-control', 'rows' => 3]) }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-blue">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('ship.lbl_no') }}</th>
                                            <th>{{ trans('ship.lbl_head_spot_type') }}</th>
                                            <th>{{ trans('ship.lbl_head_spot_price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>初期登録費</td>
                                            <td>
                                                {{ Form::text('price-1', '5000', ['class' => 'form-control']) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>データ作成費</td>
                                            <td>
                                                {{ Form::text('price-2', '6000', ['class' => 'form-control']) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-bottom">
                        {{ Form::button(trans('ship.btn_cancel_popup'), ['class' => 'center-block btn btn-gray-dark btn-w150']) }}
                        {{ Form::button(trans('ship.btn_add_service_popup'), ['class' => 'center-block btn btn-blue-dark btn-w150']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/ship-general.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            const table = document.querySelector('.tbody-scroll');
            const ps = new PerfectScrollbar(table, function () {
                table.style.height = '50px'
            });

            $('.custom-datepicker').datepicker({
                dateFormat: "yy.mm.dd"
            });
        });
    </script>
@endsection
