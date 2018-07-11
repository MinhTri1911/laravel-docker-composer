@extends('layouts.white')

@section('title',__('contract.create.header'))

@section('style')
<link rel="stylesheet" href="{{asset("/css/contract.css")}}">
@endsection

@section('menu_header')
@include('elements.service_menu')
@endsection

@section('body-class', 'contract')

@section('content')
<div class="main-content">
    <h1 class="main-heading">{{__('contract.create.header')}}</h1>
    <div class="main-summary contract-create">
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
        {{-- Start of ship block --}}
        <div class="contract-info-block">
            <div class="content-block table-block">
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_version')}}
                    </div>
                    <div class="item-value">
                        : 1.0
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_ship')}}
                    </div>
                    <div class="item-value">
                        : Tên tàu
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_currency')}}
                    </div>
                    <div class="item-value">
                        : JPY
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_service')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="input-group">
                            {!! Form::text('idService', "", ['class' => 'form-control', 'placeholder' => __('contract.lbl_service')]) !!}
                            <div class="input-group-addon show-modal-service"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </div>
                 <div class="item-row">
                    <div class="item-label">
                        Search ship
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="input-group">
                            {!! Form::text('idShip', "", ['class' => 'form-control', 'placeholder' => '']) !!}
                            <div class="input-group-addon show-modal-ship"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_start')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('Txt', date('Y/m/d'), ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_end')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('Txt', date('Y/m/d'), ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End of ship block --}}
        {{-- List contract --}}
        <div class="spot-block">
            <h4>{{__('contract.header_spot')}}</h4>     
            <div class="content-block table-block">
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>{{__('contract.lbl_type_spot')}}</th>
                            <th>{{__('contract.lbl_cost_spot')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{__('contract.lbl_spot_regist')}}</td>
                            <td>{!! Form::text('Txt', "1.000.000", ['class' => 'form-control', 'placeholder' => "課金種別"]) !!}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>{{__('contract.lbl_spot_data')}}</td>
                            <td>{!! Form::text('Txt', "1.000.000", ['class' => 'form-control', 'placeholder' => "請求金額"]) !!}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="block-handle align-right">
                    <div href="#" class="btn btn-blue-light btn-w150 pull-left">{{__('contract.btn_back')}}</div>
                    <div href="#" class="btn btn-blue-dark btn-w190 pull-left">{{__('contract.btn_create')}}</div>
                </div>
            </div>
        </div>
        {{-- End List contract --}}
    </div>
</div>
{{-- Popup Search Service --}}
{{ Form::hidden('currencyId',1) }}
{{ Form::hidden('shipId', 1) }}
{{ Form::hidden('companyId', null) }}
<div class="modal fade modal-service" id="modal-service">
    @include('search-service-master.index')
</div>
<div class="modal fade modal-ship" id="modal-ship">
    @include('search-ship-master.index')
</div>
{{-- End Popup --}}

@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/contract.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/search-service-master.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/search-ship-master.js') }}"></script>
<script>
$(document).on("click", ".show-modal-service", function () {
    $("#modal-service").modal("show")
});
$(document).on("click", ".show-modal-ship", function () {
    $("#modal-ship").modal("show")
});
</script>
@endsection