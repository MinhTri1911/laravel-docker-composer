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

        {{ Form::open(['route' => 'ship.create', 'novalidate' => 'novalidate']) }}

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

                    <div class="row">
                        <div class="col-md-12{{ $errors->has('txt-ship-name') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-ship-name') ? 'label-error' : '' }}" for="txt-ship-name">
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
                                    $viewData['selectedCompanyId'],
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
                        <div class="col-md-12{{ $errors->has('txt-mmsi-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-mmsi-number') ? 'label-error' : '' }}" for="txt-mmsi-number">
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
                        <div class="col-md-12{{ $errors->has('nation-id') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('nation-id') ? 'label-error' : '' }}" for="nation-id">
                                    {{ trans('ship.lbl_title_nation') }}
                                    <span class="require">*</span>
                                </label>
                            </div>

                            <div class="col-md-8">
                                <div class="input-group-search-popup">
                                    {{ Form::text('nation', null, [
                                            'class' => 'form-control search-nation',
                                            'placeholder' => trans('ship.lbl_title_nation'),
                                            'id' => 'nation',
                                            'tabindex' => 5,
                                            'onfocus' => "blur()"
                                        ])
                                    }}

                                    <div class="input-group-addon show-modal-service search-nation"><i class="fa fa-search"></i></div>
                                </div>

                                {{ Form::hidden('nation-id', null, ['id' => 'nation-id']) }}
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
                                {{ Form::select('slb-classification', $viewData['classification'], null, [
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
                        <div class="col-md-12{{ $errors->has('slb-ship-type') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('slb-ship-type') ? 'label-error' : '' }}" for="txt-ship-type">
                                    {{ trans('ship.lbl_title_ship_type') }}
                                    <span class="require">*</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('slb-ship-type', $viewData['shipType'], null, [
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
                        <div class="col-md-12{{ $errors->has('txt-ship-width') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-ship-width') ? 'label-error' : '' }}" for="txt-ship-width">
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
                        <div class="col-md-12{{ $errors->has('txt-water-draft') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-water-draft') ? 'label-error' : '' }}" for="txt-water-draft">
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
                        <div class="col-md-12{{ $errors->has('txt-total-weight-ton') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-total-weight-ton') ? 'label-error' : '' }}" for="txt-total-weight-ton">
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
                        <div class="col-md-12{{ $errors->has('txt-weight-ton') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-weight-ton') ? 'label-error' : '' }}" for="txt-weight-ton">
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
                        <div class="col-md-12{{ $errors->has('txt-member-number') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-member-number') ? 'label-error' : '' }}" for="txt-member-number">
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
                        <div class="col-md-12{{ $errors->has('txt-url-1') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-1') ? 'label-error' : '' }}" for="txt-url-1">
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
                        <div class="col-md-12{{ $errors->has('txt-url-2') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-2') ? 'label-error' : '' }}" for="txt-url-2">
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
                        <div class="col-md-12{{ $errors->has('txt-url-3') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-url-3') ? 'label-error' : '' }}" for="txt-url-3">
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
                        <div class="col-md-12{{ $errors->has('txt-remark') ? ' has-error' : '' }}">
                            <div class="col-md-4">
                                <label class="{{ $errors->has('txt-remark') ? 'label-error' : '' }}" for="txt-remark">
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
                        <div class="col-md-8 col-md-offset-2 mg-t-20">
                            <div class="block-button">
                                @if (Roles::checkPermission(Constant::ALLOW_SHIP_CREATE, Constant::IS_CHECK_BUTTON))
                                {{ Form::button(trans('ship.btn_create_ship'), [
                                        'class' => 'btn btn-green-dark btn-w150 btn-right',
                                        'type' => 'submit',
                                        'tabindex' => 20,
                                    ])
                                }}
                                @endif
                                @php
                                    $companyId = \Request::get('company-id');
                                    $backUrl = !empty($companyId) ? route('ship.index') . '?company-id=' . $companyId : route('ship.index');
                                @endphp
                                <a href="{{ $backUrl }}" class="btn btn-gray-dark btn-w150 btn-right" tabindex="19">{{ trans('ship.btn_back') }}</a>
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
        @php $nations = $viewData['nation']; @endphp
        @include('common.popup-search-nation')
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/nation-search.js') }}"></script>
@endsection
