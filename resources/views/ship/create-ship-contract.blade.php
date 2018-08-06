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
            @if ($errors->all())
                <div class="alert alert-danger alert-show">
                    @foreach ($errors->all() as $error)
                        <div class="block-error">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            <label class="control-label">
                                {{ $error }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="append-mess-warning"></div>

            {{ Form::open(['url' => route('ship.contract.store'), 'method' => 'POST']) }}
                {{ Form::hidden('company-id', $companyId) }}
                {{ Form::hidden('currency-id', $currencyId) }}
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
                            <div class="col-md-8 {{ $errors->has('txt-ship-name') ? ' has-error' : '' }}">
                                {{ Form::text('txt-ship-name', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_name'),
                                        'tabindex' => 1,
                                        'require' => true,
                                        'id' => 'txt-ship-name',
                                        'data-url' => route('ship.check.exists.data'),
                                        'data-remark' => '',
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
                                <label class="lbl-title">
                                    {{ $company->name_jp }}
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-imo-number">
                                    {{ trans('ship.lbl_title_imo_number') . trans('ship.icon_title') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 {{ $errors->has('txt-imo-number') ? ' has-error' : '' }}">
                                {{ Form::text('txt-imo-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_imo_number'),
                                        'tabindex' => 2,
                                        'id' => 'txt-imo-number',
                                        'data-url' => route('ship.check.exists.data'),
                                        'data-remark' => '',
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
                            <div class="col-md-8 {{ $errors->has('txt-mmsi-number') ? ' has-error' : '' }}">
                                {{ Form::text('txt-mmsi-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_mmsi_number'),
                                        'tabindex' => 3,
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

                            <div class="col-md-8 {{ $errors->has('nation-id') ? ' has-error' : '' }}">
                                <div class="input-group-search-popup">
                                    {{ Form::text('nation', $nations->first() ? $nations->first()->name_jp : null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('ship.lbl_title_nation'),
                                            'readonly' => 'readonly',
                                            'id' => 'nation',
                                            'tabindex' => 4,
                                        ])
                                    }}
                                    <div class="input-group-addon show-modal-service" id="search-nation"><i class="fa fa-search"></i></div>
                                </div>

                                {{ Form::hidden('nation-id', $nations->first() ? $nations->first()->id : null, ['id' => 'nation-id']) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="slb-classification">
                                    {{ trans('ship.lbl_title_classification') . trans('ship.icon_title') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select {{ $errors->has('slb-classification') ? ' has-error' : '' }}">
                                @php
                                    $dataClassification = [];
                                    $firstValue = $classificationies->first() ? $classificationies->first()->id : null;

                                    foreach ($classificationies as $class) {
                                        $dataClassification[$class->id] = $class->name_jp . ' (' . $class->code . ')';
                                    }
                                @endphp
                                {{ Form::select('slb-classification', $dataClassification, $firstValue, [
                                        'class' => 'form-control',
                                        'tabindex' => 5,
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
                            <div class="col-md-8 custom-select {{ $errors->has('txt-register-number') ? ' has-error' : '' }}">
                                {{ Form::text('txt-register-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_register_number'),
                                        'tabindex' => 6,
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
                            <div class="col-md-8 custom-select {{ $errors->has('slb-ship-type') ? ' has-error' : '' }}">
                                @php
                                    $dataShipType = [];
                                    $firstValueShipType = $shipTypes->first() ? $shipTypes->first()->id : null;

                                    foreach ($shipTypes as $shipType) {
                                        $dataShipType[$shipType->id] = $shipType->type . ' (' . $shipType->code . ')';
                                    }
                                @endphp
                                {{ Form::select('slb-ship-type', $dataShipType, $firstValueShipType, [
                                        'class' => 'form-control',
                                        'tabindex' => 7,
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
                            <div class="col-md-8 {{ $errors->has('txt-ship-width') ? ' has-error' : '' }}">
                                {{ Form::text('txt-ship-width', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_width'),
                                        'tabindex' => 8,
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
                            <div class="col-md-8 {{ $errors->has('txt-ship-length') ? ' has-error' : '' }}">
                                {{ Form::text('txt-ship-length', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_length'),
                                        'tabindex' => 9,
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
                            <div class="col-md-8 {{ $errors->has('txt-water-draft') ? ' has-error' : '' }}">
                                {{ Form::text('txt-water-draft', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_water_draft'),
                                        'tabindex' => 10,
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
                            <div class="col-md-8 {{ $errors->has('txt-total-weight-ton') ? ' has-error' : '' }}">
                                {{ Form::text('txt-total-weight-ton', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_total_weight_ton'),
                                        'tabindex' => 11,
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
                            <div class="col-md-8 {{ $errors->has('txt-weight-ton') ? ' has-error' : '' }}">
                                {{ Form::text('txt-weight-ton', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_weight_ton'),
                                        'tabindex' => 12,
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
                            <div class="col-md-8 {{ $errors->has('txt-member-number') ? ' has-error' : '' }}">
                                {{ Form::text('txt-member-number', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_member_number'),
                                        'tabindex' => 13,
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
                            <div class="col-md-8 {{ $errors->has('txt-remark') ? ' has-error' : '' }}">
                                {{ Form::textarea('txt-remark', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_remark'),
                                        'tabindex' => 14,
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
                            <div class="col-md-8 {{ $errors->has('txt-url-1') ? ' has-error' : '' }}">
                                {{ Form::text('txt-url-1', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_1'),
                                        'tabindex' => 15,
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
                            <div class="col-md-8 {{ $errors->has('txt-url-2') ? ' has-error' : '' }}">
                                {{ Form::text('txt-url-2', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_2'),
                                        'tabindex' => 16,
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
                            <div class="col-md-8 {{ $errors->has('txt-url-3') ? ' has-error' : '' }}">
                                {{ Form::text('txt-url-3', '', [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_3'),
                                        'tabindex' => 17,
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
                                        'tabindex' => 18,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                    <!-- end block form right -->
                </div>

                <div class="row"></div>

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
                            <tbody class="tbody-scroll" id="service-append-data">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end table show add service -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 block-button">
                            {{ Form::button(trans('ship.btn_add_ship'), [
                                    'class' => 'btn btn-green-dark btn-w150 btn-right',
                                    'type' => 'submit',
                                    'tabindex' => 20,
                                ])
                            }}
                            <a class="btn btn-blue-light btn-w150 btn-right" href="{{ route('company.show', $companyId) }}" tabindex="19">
                                {{ trans('ship.btn_back') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div id="service-data-hidden">
                </div>
            {{ Form::close() }}
        </div>
    </div>

    <div class="modal modal-protector modal-normal fade" id="popup-add-service" tabindex="-1" role="dialog">
        <div class="modal-close">
            <button class="btn-close-modal" data-dismiss="modal"></button>
            <label>{{ trans('common.btn_close_modal') }}</label>
        </div>
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="popup-title">
                    <h2>{{ trans('ship.lbl_head_add_service') }}</h2>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger error-start-date">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label" id="lbl-error-start-date">
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-danger error-end-date">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label" id="lbl-error-end-date">
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-danger error-remark">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label" id="lbl-error-remark">
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-danger error-charge-register">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label" id="lbl-error-charge-register">
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-danger error-charge-create-data">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label" id="lbl-error-charge-create-data">
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-success success-create-data">
                            <div class="block-success">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                  <label class="control-label">{{ trans('common-message.inform.I032') }}</label>
                             </div>
                        </div>

                        <div class="alert alert-warning" id="warning-service-duplicate">
                            <div class="block-warning">
                                <label class="control-label">
                                    {{ trans('common-message.error.E021', ['item' => trans('company.lbl_service_name')]) }}
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
                                    @php
                                        $servicesData = [];
                                        $servicesPrice = [];
                                        $firstServiceData = $services->first() ? $services->first()->id : 0;

                                        foreach ($services as $service) {
                                            $servicesData[$service->id] = $service->name_jp;
                                            $servicesPrice[$service->id] = [
                                                'price' => $service->price,
                                                'chargeRegister' => $service->charge_register,
                                                'chargeCreateData' => $service->charge_create_data,
                                            ];
                                        }
                                    @endphp
                                    {{ Form::select('slb-service', $servicesData, $firstServiceData, [
                                            'class' => 'form-control',
                                            'id' => 'slb-service',
                                        ])
                                    }}
                                </div>
                                {{ Form::hidden('service-price', json_encode($servicesPrice), ['id' => 'service-price']) }}
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_service_version') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl-title">{{ number_format(1, 2) }}</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_title_currecy_use') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl-title">
                                        {{ $services->first()->currency_name_jp . ' (' . $services->first()->currency_code . ')' }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_service_price') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="lbl-title" id="lbl-price-service">
                                        {{ $services->first()->price }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>{{ trans('ship.lbl_start_date') . trans('ship.icon_title') }}</label>
                                </div>
                                <div class="col-md-6 service-start-date">
                                    <div class="group-datepicker">
                                        {{ Form::text('service-start-date', null, [
                                                'class' => 'form-control custom-datepicker',
                                                'id' => 'service-start-date',
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
                                <div class="col-md-6 service-end-date">
                                    <div class="group-datepicker">
                                        {{ Form::text('service-end-date', null, [
                                                'class' => 'form-control custom-datepicker',
                                                'id' => 'service-end-date',
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
                                <div class="col-md-6 txt-remark">
                                    {{ Form::textarea('txt-remark', '', ['class' => 'form-control', 'rows' => 3, 'id' => 'txt-remark']) }}
                                </div>
                            </div>

                            <div class="col-md-12 table-default">
                                <table class="table table-blue">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('ship.lbl_no') }}</th>
                                            <th>{{ trans('ship.lbl_head_spot_type') }}</th>
                                            <th>{{ trans('ship.lbl_head_spot_price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $priceRegister = $services->first()
                                                ? $services->first()->charge_register
                                                : 0;

                                            $priceCreateData = $services->first()
                                                ? $services->first()->charge_create_data
                                                : 0;

                                            $spotRegister = 'charge-register';
                                            $spotCreateData = 'charge-create-data';
                                        @endphp
                                        @foreach ($spotDefault as $index => $spot)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $spot->name_jp }}</td>
                                                <td class="{{ $spot->type == Constant::SPOT_TYPE_REGISTER ? $spotRegister : $spotCreateData }}">
                                                    {{ Form::text($spot->type == Constant::SPOT_TYPE_REGISTER ? $spotRegister : $spotCreateData,
                                                        $spot->type == Constant::SPOT_TYPE_REGISTER ? $priceRegister : $priceCreateData, [
                                                            'class' => 'form-control',
                                                            'id' => $spot->type == Constant::SPOT_TYPE_REGISTER ? $spotRegister : $spotCreateData,
                                                            'data-id' => $spot->id,
                                                        ])
                                                    }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-bottom">
                        {{ Form::button(trans('ship.btn_cancel_popup'), [
                                'class' => 'center-block btn btn-gray-dark btn-w150',
                                'id' => 'btn-close-popup',
                                'data-dismiss' => 'modal',
                            ])
                        }}
                        {{ Form::button(trans('ship.btn_add_service_popup'), [
                                'class' => 'center-block btn btn-blue-dark btn-w150',
                                'id' => 'btn-add-service-to-table',
                            ])
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-protector modal-normal fade" id="popup-search-nation" tabindex="-1" role="dialog">
        @include('common.popup-search-nation', ['type' => 'ship'])
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
        window.Laravel = {!! json_encode([
            'startDateRequire' => trans('common-message.error.E003', ['item' => trans('ship.lbl_start_date')]),
            'endDateRequire' => trans('common-message.error.E003', ['item' => trans('ship.lbl_end_date')]),
            'startDateFormat' => trans('common-message.error.E005', ['item' => trans('ship.lbl_end_date')]),
            'endDateFormat' => trans('common-message.error.E005', ['item' => trans('ship.lbl_end_date')]),
            'remarkMaxLenght' => trans('common-message.error.E004', [
                'item' => trans('ship.lbl_contract_remark'),
                'value' => 255
            ]),
            'chargeRegisterMaxLength' => trans('common-message.error.E004', [
                'item' => trans('ship.lbl_title_spot_charge_register'),
                'value' => 18
            ]),
            'chargeCreateDataMaxLength' => trans('common-message.error.E004', [
                'item' => trans('ship.lbl_title_spot_charge_create_data'),
                'value' => 18
            ]),
            'startDateBeforNow' => trans('common-message.error.E020', [
                'item' => trans('ship.lbl_start_date'),
                'value' => trans('ship.now'),
            ]),
            'endDateBeforStartDate' => trans('common-message.error.E020', [
                'item' => trans('ship.lbl_end_date'),
                'value' => trans('ship.lbl_start_date'),
            ]),
        ]) !!}

    </script>
    <script type="text/javascript" src="{{ asset('js/create-ship-contract.js') }}"></script>
@endsection
