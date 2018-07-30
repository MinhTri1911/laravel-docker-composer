@extends('layouts.white')

@section('title', trans('ship.edit.title_ship'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/ship-general.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-ship')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('ship.edit.header_ship') }}</h1>

        {{ Form::open(['route' => ['ship.update', 'id' => $viewData['ship']->id], 'novalidate' => 'novalidate']) }}

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="main-summary pd-bt-60">

                    <div class="title">
                        <h2>{{ trans('ship.lbl_ship_infomation') }}</h2>
                    </div>

                    @if ($errors->count() > 0)
                        <div class="alert alert-danger">
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

                    <div id="warning-messages"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txt-ship-id">船舶ID</label>
                            </div>
                            <div class="col-md-8">{{ $viewData['ship']->id }}</div>
                            <input type="hidden" id="ship-id" value="{{ $viewData['ship']->id }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-ship-name') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-ship-name') ? 'label-error' : '' }}" for="txt-ship-name">
                                    {{ trans('ship.lbl_title_ship_name') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-name',
                                    $viewData['ship']->name,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_name'),
                                        'tabindex' => 1,
                                        'require' => true,
                                        'id' => 'ship-name',
                                        'data-name' => $viewData['ship']->name,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('slb-company') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('slb-company') ? 'label-error' : '' }}" for="slb-company">
                                    {{ trans('ship.lbl_title_company') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select(
                                    'slb-company',
                                    $viewData['company'],
                                    $viewData['ship']->company_id,
                                    [
                                        'class' => 'form-control',
                                        'tabindex' => 2
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-imo-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-imo-number') ? 'label-error' : '' }}" for="txt-imo-number">
                                    {{ trans('ship.lbl_title_imo_number') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-imo-number',
                                    $viewData['ship']->imo_number,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_imo_number'),
                                        'tabindex' => 3,
                                        'id' => 'imo-number',
                                        'data-name' => $viewData['ship']->imo_number,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-mmsi-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-mmsi-number') ? 'label-error' : '' }}" for="txt-mmsi-number">
                                    {{ trans('ship.lbl_title_mmsi_number') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-mmsi-number',
                                    $viewData['ship']->mmsi_number,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_mmsi_number'),
                                        'tabindex' => 4,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('nation-id') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('nation-id') ? 'label-error' : '' }}" for="nation-id">
                                    {{ trans('ship.lbl_title_nation') }}
                                    <span class="require">*</span>
                                </label>
                            </div>

                            <div class="col-md-8">
                                <div class="input-group-search-popup">
                                    {{ Form::text('nation',
                                        @$viewData['nation'][$viewData['ship']->nation_id - 1]->name_jp,
                                        [
                                            'class' => 'form-control search-nation',
                                            'placeholder' => trans('ship.lbl_title_nation'),
                                            'id' => 'nation',
                                            'tabindex' => 5,
                                            'onfocus' => "blur()"
                                        ])
                                    }}

                                    <div class="input-group-addon show-modal-service search-nation"><i class="fa fa-search"></i></div>
                                </div>

                                {{ Form::hidden('nation-id', $viewData['ship']->nation_id, ['id' => 'nation-id']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('slb-classification') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('slb-classification') ? 'label-error' : '' }}" for="slb-classification">
                                    {{ trans('ship.lbl_title_classification') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-classification',
                                    $viewData['classification'],
                                    $viewData['ship']->classification_id,
                                    [
                                        'class' => 'form-control',
                                        'tabindex' => 6,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-register-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-register-number') ? 'label-error' : '' }}" for="txt-register-number">
                                    {{ trans('ship.lbl_title_register_number') }}
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::text('txt-register-number',
                                    $viewData['ship']->register_number,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_register_number'),
                                        'tabindex' => 7,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('slb-ship-type') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('slb-ship-type') ? 'label-error' : '' }}" for="txt-ship-type">
                                    {{ trans('ship.lbl_title_ship_type') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-ship-type',
                                    $viewData['shipType'],
                                    $viewData['ship']->type_id,
                                    [
                                        'class' => 'form-control',
                                        'tabindex' => 8,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-ship-length') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-ship-length') ? 'label-error' : '' }}" for="txt-ship-length">
                                    {{ trans('ship.lbl_title_ship_length') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-length',
                                    $viewData['ship']->height,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_length'),
                                        'tabindex' => 9,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-ship-width') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-ship-width') ? 'label-error' : '' }}" for="txt-ship-width">
                                    {{ trans('ship.lbl_title_ship_width') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-ship-width',
                                    $viewData['ship']->width,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_ship_width'),
                                        'tabindex' => 10,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-water-draft') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-water-draft') ? 'label-error' : '' }}" for="txt-water-draft">
                                    {{ trans('ship.lbl_title_water_draft') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-water-draft',
                                    $viewData['ship']->water_draft,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_water_draft'),
                                        'tabindex' => 11,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-total-weight-ton') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-total-weight-ton') ? 'label-error' : '' }}" for="txt-total-weight-ton">
                                    {{ trans('ship.lbl_title_total_weight_ton') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-total-weight-ton',
                                    $viewData['ship']->total_weight_ton,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_total_weight_ton'),
                                        'tabindex' => 12,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-weight-ton') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-weight-ton') ? 'label-error' : '' }}" for="txt-weight-ton">
                                    {{ trans('ship.lbl_title_weight_ton') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-weight-ton',
                                    $viewData['ship']->total_ton,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_weight_ton'),
                                        'tabindex' => 13,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-member-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-member-number') ? 'label-error' : '' }}" for="txt-member-number">
                                    {{ trans('ship.lbl_title_member_number') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-member-number',
                                    $viewData['ship']->member_number,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_title_member_number'),
                                        'tabindex' => 14,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-url-1') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-1') ? 'label-error' : '' }}" for="txt-url-1">
                                    {{ trans('ship.lbl_url_1') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-1',
                                    $viewData['ship']->url_1,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_1'),
                                        'tabindex' => 16,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-url-2') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-2') ? 'label-error' : '' }}" for="txt-url-2">
                                    {{ trans('ship.lbl_url_2') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-2',
                                    $viewData['ship']->url_2,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_2'),
                                        'tabindex' => 17,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-url-3') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-3') ? 'label-error' : '' }}" for="txt-url-3">
                                    {{ trans('ship.lbl_url_3') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::text('txt-url-3',
                                    $viewData['ship']->url_3,
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => trans('ship.lbl_url_3'),
                                        'tabindex' => 18,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-remark') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-remark') ? 'label-error' : '' }}" for="txt-remark">
                                    {{ trans('ship.lbl_title_remark') }}
                                </label>
                            </div>
                            <div class="col-md-8">
                                {{ Form::textarea('txt-remark',
                                    $viewData['ship']->remark,
                                    [
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
                        <div class="col-md-8 col-md-offset-2 mg-t-20">
                            <div class="block-button">
                                @if (Roles::checkPermission(Constant::ALLOW_SHIP_CREATE, Constant::IS_CHECK_BUTTON))
                                    {{ Form::button(trans('ship.edit.btn_update'), [
                                            'class' => 'btn btn-green-dark btn-w150 btn-right',
                                            'type' => 'submit',
                                            'tabindex' => 20,
                                        ])
                                    }}
                                @endif
                                <a href="{{ route('ship.contract.detail', ['id' => $viewData['ship']->id]) }}" class="btn btn-blue-light btn-w150 btn-right" tabindex="19">{{ trans('ship.btn_back') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    {{-- Include common nation search --}}
    <div class="modal modal-protector modal-normal fade" id="popup-search-nation" tabindex="-1" role="dialog">
        @php
            $nations = $viewData['nation'];
            $type = 'ship';
        @endphp
        @include('common.popup-search-nation')
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        var checkExist = new function () {

            this.models = {
                shipId: "#ship-id",
                shipName: "#ship-name",
                imoNumber: '#imo-number',
                warning: '#warning-messages',
            };

            this.init = function () {

                $(document).on('blur', checkExist.models.shipName, function (e) {
                    var shipId = $(checkExist.models.shipId).val();
                    var shipName = $(this).val();
                    var imoNumber = $(checkExist.models.imoNumber).val();
                    checkExist.events.checkExistShipName(shipId, shipName, imoNumber);
                });

                $(document).on('blur', checkExist.models.imoNumber, function (e) {
                    var shipId = $(checkExist.models.shipId).val();
                    var imoNumber = $(this).val();
                    var shipName = $(checkExist.models.shipName).val();
                    checkExist.events.checkExistShipName(shipId, shipName, imoNumber);
                });

            };

            this.events = {

                checkExistShipName: function (shipId, shipName, imoNumber) {

                    var url = location.protocol + "//" + location.host + '/ship/check-edit-exist';

                    // Handle ajax send data to server
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            "shipId": shipId,
                            "shipName": shipName,
                            "imoNumber": imoNumber
                        },
                        success: function (res) {
                            $(checkExist.models.warning).html(res.html);
                        },
                        // Not do anything when error
                        error: function (error) {
                            console.error(error);
                            return false;
                        }
                    });
                }
            };

        };

        $(document).ready(function () {
            checkExist.init();
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/nation-search.js') }}"></script>
@endsection
