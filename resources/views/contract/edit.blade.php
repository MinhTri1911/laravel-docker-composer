@extends('layouts.white')

@section('title',__('contract.edit.header'))

@section('style')
    <link rel="stylesheet" href="{{asset("/css/contract.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'contract')

@section('content')
<div class="main-content">
    <h1 class="main-heading">{{__('contract.edit.header')}}</h1>
    <div class="main-summary contract-edit">
        @if(count($errors->all()) > 0)
        <div class="alert alert-danger">
            @foreach($errors->messages() as $attribute => $error)
                @if($error !== 'msg_default')
                <div class="block-error">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <label class="control-label">
                        {{$errors->first($attribute)}}
                    </label>
                </div>
                @endif
            @endforeach
        </div>
        @endif
        {!!
            Form::open([
                'route' => ['contract.update', $contract->contract_ship_id, $contract->contract_id],
                'method' => 'PUT',
            ])
        !!}
        @if(isset($contract) && count($contract) > 0)
            {{-- Start of ship block --}}
            <div class="contract-info-block">
                <div class="content-block table-block">
                    <div class="item-row">
                        <div class="item-label">
                            {{__('contract.lbl_id_contract')}}
                        </div>
                        <div class="item-value">
                            : {{$contract->contract_id}}
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-label">
                            {{__('contract.lbl_version')}}
                        </div>
                        <div class="item-value">
                            : {{$contract->contract_revision_number}}
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-label">
                            {{__('contract.lbl_ship')}}
                        </div>
                        <div class="item-value">
                            : {{$contract->contract_ship_name}}
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="item-label">
                            {{__('contract.lbl_currency')}}
                        </div>
                        <div class="item-value">
                            : {{$contract->contract_currency_name}}
                        </div>
                    </div>
                    <div class="item-row {{ $errors->has('serviceIdHidden') ? 'has-error' : '' }}">
                        <div class="item-label {{ $errors->has('serviceIdHidden') ? 'label-error' : '' }}">
                            {{__('contract.lbl_service')}}
                            <span class="require">*</span>
                        </div>
                        <div class="item-value">
                            <div class="input-group">
                                {!! Form::text('idService', $contract->contract_service_name??null, ['class' => 'form-control', 'readonly'=>'readonly', 'placeholder' => __('contract.lbl_service')]) !!}
                                <div class="input-group-addon show-modal-service"><i class="fa fa-search"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="item-row {{ $errors->has('startDate') ? 'has-error' : '' }}">
                        <div class="item-label {{ $errors->has('startDate') ? 'label-error' : '' }}">
                            {{__('contract.lbl_start')}}
                            <span class="require">*</span>
                        </div>
                        <div class="item-value">
                            <div class="group-datepicker">
                                {!! Form::text('startDate', $errors->has('startDate')?old('startDate'):($contract->contract_start_date??null), ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="item-row {{ $errors->has('endDate') ? 'has-error' : '' }}">
                        <div class="item-label {{ $errors->has('endDate') ? 'label-error' : null }}">
                            {{__('contract.lbl_end')}}
                            <span class="require">*</span>
                        </div>
                        <div class="item-value">
                            <div class="group-datepicker">
                                {!! Form::text('endDate', $errors->has('endDate')?old('endDate'):($contract->contract_end_date??null), ['class' => 'form-control custom-datepicker', 'placeholder' => date('Y/m/d')]) !!}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="item-row {{ $errors->has('remark') ? 'has-error' : null }}">
                        <div class="item-label {{ $errors->has('remark') ? 'label-error' : null }}"  style="vertical-align: top;">
                            {{__('contract.lbl_remarks')}}
                        </div>
                        <div class="item-value">
                            <div class="input-group">
                                {{ Form::textarea('remark', $contract->contract_remark, [
                                    'class' => 'form-control',
                                    'placeholder' => __('contract.lbl_remarks'),
                                    'rows' => '3',
                                    'style' => 'width: 20%;z-index: 1;',
                                ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of ship block --}}
            {{-- List spot --}}
            <div class="spot-block">
                @if( $errors->any() && (old('chargeRegister') || old('chargeCreate')) )
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
                                <td class="{{ $errors->has('chargeRegister') ? ' has-error' : '' }}">{!! Form::text('chargeRegister', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_spot_regist')]) !!}</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>{{__('contract.lbl_spot_data')}}</td>
                                <td class="{{ $errors->has('chargeCreate') ? ' has-error' : '' }}">{!! Form::text('chargeCreate', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_spot_data')]) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            </div>
            <div class="block-handle align-right">
                <a href="{{route('ship.contract.detail', $contract->contract_ship_id)}}" class="btn btn-blue-light btn-w150 pull-left">{{__('contract.btn_back')}}</a>
                <button class="btn btn-green-dark btn-w150 pull-left">{{__('contract.btn_update')}}</button>
            </div>
            {{-- End List spot --}}
        @endif
    </div>
    {{ Form::hidden('currencyId', $contract->contract_currency_id) }}
    {{ Form::hidden('shipId', $contract->contract_ship_id) }}
    {{ Form::hidden('serviceIdHidden', $contract->contract_service_id) }}
    {!! Form::close() !!}
</div>
{{-- Popup --}}
<div class="modal fade modal-service" id="modal-service">
    @include('search-service-master.index')
</div>
<div class="modal fade modal-ship" id="modal-ship">
    @include('search-ship-master.index')
</div>
{{-- End Popup --}}
@endsection

@section('javascript')
<script type="text/javascript">
    var dataTrans = {
        "spot": {
            "head_main_spot": "{{__('contract.header_spot')}}",
            "head_type_1": "{{__('contract.lbl_type_spot')}}",
            "head_type_2": "{{__('contract.lbl_cost_spot')}}",
            "spot_regist": "{{__('contract.lbl_spot_regist')}}",
            "spot_create": "{{__('contract.lbl_spot_data')}}"
        }
    };
</script>
<script type="text/javascript" src="{{ asset('js/contract.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/search-service-master.js') }}"></script>
<script>
    $(document).on("click",".show-modal-service",function(){$("#modal-service").modal("show")});
</script>
@endsection