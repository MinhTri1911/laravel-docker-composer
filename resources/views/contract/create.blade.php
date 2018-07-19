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
    {!! Form::open(['route' => 'contract.create']) !!}
    <div class="main-summary contract-create">
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
                        : {{ $ship->name }}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('contract.lbl_currency')}}
                    </div>
                    <div class="item-value">
                        : {{ $ship->code }}
                    </div>
                </div>
                <div class="item-row {{ $errors->has('idService') ? ' has-error' : '' }}">
                    <div class="item-label">
                        {{__('contract.lbl_service')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="input-group">
                            {!! Form::text('idService', old('idService'), ['class' => 'form-control', 'placeholder' => __('contract.lbl_service'),'readonly'=>'readonly','tabindex' => '1']) !!}
                            <div class="input-group-addon show-modal-service"><i class="fa fa-search"></i></div>
                        </div>
                    </div>
                </div>
                <div class="item-row {{ $errors->has('dateStart') ? ' has-error' : '' }}">
                    <div class="item-label">
                        {{__('contract.lbl_start')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('dateStart', old('dateStart'), ['class' => 'form-control custom-datepicker', 'placeholder' => 'YYYY/MM/dd','tabindex' => '2']) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="item-row {{ $errors->has('dateEnd') ? ' has-error' : '' }}">
                    <div class="item-label">
                        {{__('contract.lbl_end')}}
                        <span class="require">*</span>
                    </div>
                    <div class="item-value">
                        <div class="group-datepicker">
                            {!! Form::text('dateEnd', old('dateEnd'), ['class' => 'form-control custom-datepicker', 'placeholder' => 'YYYY/MM/dd','tabindex' => '3']) !!}
                            <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label"  style="padding-bottom: 70px;">
                        {{__('contract.lbl_remarks')}}
                    </div>
                    <div class="item-value">
                        <div class="input-group">
                            {{ Form::textarea('remark', old('remark'), [
                                'class' => 'form-control',
                                'placeholder' => trans('contract.lbl_remarks'),
                                'tabindex' => 15,
                                'rows' => '3',
                                'style' => 'width: 20%;z-index: 1;',
                                'tabindex' => '4'
                            ])
                            }}
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
                <table class="table table-blue table-ship resizable">
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
                            <td class="{{ $errors->has('chargeRegister') ? ' has-error' : '' }}">{!! Form::text('chargeRegister', old('chargeRegister'), ['tabindex' => '5','class' => 'form-control', 'placeholder' => "初期登録費"]) !!}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>{{__('contract.lbl_spot_data')}}</td>
                            <td class="{{ $errors->has('chargeCreate') ? ' has-error' : '' }}">{!! Form::text('chargeCreate', old('chargeCreate'), ['tabindex' => '6','class' => 'form-control', 'placeholder' => "データ作成費"]) !!}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="block-handle align-right">
                    <a href="{{ route('ship.contract.detail', $ship->id) }}"><div class="btn btn-blue-light btn-w150 pull-left" tabindex=7 >{{__('contract.btn_back')}}</div></a>
                    <button type="submit" class="btn btn-blue-dark btn-w190" tabindex=8>{{__('contract.btn_create')}}</button>
                </div>
            </div>
        </div>
        {{-- End List contract --}}
    </div>
    {{ Form::hidden('currencyId',$ship->currency_id) }}
    {{ Form::hidden('shipId', $ship->id) }}
    {{ Form::hidden('serviceIdHidden','') }}
    {!! Form::close() !!}
</div>
{{-- Popup Search Service --}}

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
<script>

$(document).on("click", ".show-modal-service", function () {
    $("#modal-service").modal("show")
});
$(document).on("click", ".show-modal-ship", function () {
    $("#modal-ship").modal("show")
});
</script>
@endsection