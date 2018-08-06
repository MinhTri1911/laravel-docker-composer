@extends('layouts.white')

@section('title', trans('spot.title_header_create_spot'))

@section('style')
    <link rel="stylesheet" href="{{ asset("/css/spot.css") }}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'create-spot')

@section('content')
    <div class="main-content">
        <h1 class="main-heading">{{ trans('spot.title_header_create_spot') }}</h1>

        {!! Form::open(['route' => 'ship.spot.create']) !!}

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="main-summary pd-bt-60">
                    <!-- begin alert errors -->
                    @if($errors->all())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div class="block-error">
                                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                                    <label class="control-label">
                                        {{ $error }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <!-- end alert errors -->
                    <!-- begin form input ship spot information -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>{{ trans('spot.lbl_ship_name') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label>{{ trans('spot.icon_content') }} {{ $ship->name }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>
                                    {{ trans('spot.lbl_spot_name') }}
                                    <span class="require">{{ trans('spot.icon_require') }}</span>
                                </label>
                            </div>
                            <div class="col-md-8 custom-select">
                                {{ Form::select('spotId', $spotNameSelect, null, ['class' => 'form-control', 'id' => 'spot-id', 'tabindex' => '1']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>
                                    {{ trans('spot.lbl_spot_month_usage') }}
                                    <span class="require">{{ trans('spot.icon_require') }}</span>
                                </label>
                            </div>
                            <div class="col-md-8 {{ $errors->has('dateStart') ? ' has-error' : '' }}">
                                <div class="group-datepicker">
                                    {{ Form::text('dateStart', null, [
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
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>
                                    {{ trans('spot.lbl_spot_amount_charge') }}
                                    <span class="require">{{ trans('spot.icon_require') }}</span>
                                </label>
                            </div>
                            <div class="col-md-8 {{ $errors->has('amountCharge') ? ' has-error' : '' }}">
                                {{ Form::text('amountCharge', old('amountCharge',$amountCharge), [
                                        'class' => 'form-control',
                                        'placeholder' => trans('spot.lbl_spot_amount_charge'),
                                        'tabindex' => 3,
                                    ])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>{{ trans('spot.lbl_spot_currency') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label>{{ trans('spot.icon_content') }} {{ $currencyCode->code }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>{{ trans('spot.lbl_spot_remark') }}</label>
                            </div>
                            <div class="col-md-8 {{ $errors->has('remark') ? ' has-error' : '' }}">
                                {{ Form::textarea('remark', null, [
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
                        <div class="col-md-8 col-md-offset-2 mg-t-10">
                            <div class="block-button">
                                {{ Form::button(trans('spot.btn_create_spot'), [
                                        'class' => 'btn btn-green-dark btn-w150',
                                        'tabindex' => 6,
                                        'type'=>'submit',
                                    ])
                                }}
                                <a href="{{ route('ship.contract.detail', $ship->id) }}">
                                    {{ Form::button(trans('spot.btn_back'), [
                                            'class' => 'btn btn-blue-light btn-w150',
                                            'tabindex' =>5,
                                        ])
                                    }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end form input ship spot infomation -->
        </div>
        {{ Form::hidden('currencyId',$ship->currency_id) }}
        {{ Form::hidden('shipId', $ship->id) }}
        {!! Form::close() !!}
    </div>
@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('js/datetimepicker-general.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/spot-create.js') }}"></script>
    <script type="text/javascript">
        $('.custom-datepicker').datepicker({
            dateFormat: "yy/mm/dd"
        });
    </script>
@endsection
