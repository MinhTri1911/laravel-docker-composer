@extends('layouts.white')

@section('title', $ship->detail_ship->ship_name)

@section('style')
    <link rel="stylesheet" href="{{asset("/css/ship-contract.css")}}">
@endsection

@section('menu_header')
    @include('elements.service_menu')
@endsection

@section('body-class', 'ship-contract-page')

@section('content')
<div class="main-content" id="ship-contract">
    <h1 class="main-heading">{{__('ship-contract.detail.header_ship_contract')}}</h1>
    <div class="main-summary detail-ship">
        {{-- Start of ship block --}}
        <div class="ship-info-block">
            <h4> {{__('ship-contract.detail.header_ship_info')}}</h4>
            <div class="content-block table-block">
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_id')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_id}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_name')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_name}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_company')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->company_name}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_imo')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_imo_number}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_mmsi')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_mmsi_number}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_nation')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->nation_name}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_level')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_classify}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_code')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_register_number}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_type')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_type}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_wide')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_width}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_long')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_height}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_mon')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_water_draft}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_quan')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_total_weight_ton}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_weight')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_weight_ton}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_teu')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_member_number}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_note')}}
                    </div>
                    <div class="item-value">
                        {{$ship->detail_ship->ship_remark}}
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url1')}}
                    </div>
                    <div class="item-value">
                        <a href="#">{{$ship->detail_ship->ship_url_1}}</a>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url2')}}
                    </div>
                    <div class="item-value">
                        <a href="#">{{$ship->detail_ship->ship_url_2}}</a>
                    </div>
                </div>
                <div class="item-row">
                    <div class="item-label">
                        {{__('ship-contract.detail.lbl_ship_url3')}}
                    </div>
                    <div class="item-value">
                        <a href="#">{{$ship->detail_ship->ship_url_3}}</a>
                    </div>
                </div>
            </div>
            <div class="block-handle align-center">
                <a href="{{route('ship.edit', $ship->detail_ship->ship_id)}}" class="btn btn-blue-dark btn-w150">{{__('ship-contract.detail.btn_edit_ship')}}</a>
            </div>
        </div>
        {{-- End of ship block --}}
        @if(property_exists($ship, 'contracts') && !is_null($ship->contracts) && $ship->contracts->count() > 0)
        {{-- List contract --}}
        <div class="contract-block">
            <h4>{{__('ship-contract.detail.lbl_ship_contract')}}</h4>
            <div class="content-block table-block">
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            <th style="" class="custom-checkbox">
                                <input class="hidden" id="chk_ct_full" type="checkbox">
                                <label for="chk_ct_full"></label>
                            </th>
                            <th>{{__('ship-contract.detail.lbl_contract_id')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_version')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_service')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_start')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_end')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_status')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_approve')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_date_create')}}</th>
                            <th>{{__('ship-contract.detail.lbl_contract_date_update')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ship->contracts as $contract)
                        <tr>
                            <td class="custom-checkbox">
                                <input class="hidden" id="chk_contract_{{$contract->contract_id}}" name="contract" type="checkbox">
                                <label for="chk_contract_{{$contract->contract_id}}"></label>
                            </td>
                            <td style="word-wrap: break-word;">{{$contract->contract_id}}</td>
                            <td style="word-wrap: break-word;">{{(float)$contract->contract_revision_number}}</td>
                            <td style="word-wrap: break-word;">{{$contract->service_name}}</td>
                            <td style="">{{$contract->contract_date_start}}</td>
                            <td style="">{{$contract->contract_date_end}}</td>
                            <td>
                                <span class="status-contract-{{$contract->contract_id}}">
                                    @if($contract->contract_status == 0)
                                    Đang hoạt động
                                    @elseif($contract->contract_status == 1)
                                    Đang pending
                                    @else
                                    Đã ngừng
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="approve-contract-{{$contract->contract_id}}">
                                    @if($contract->contract_approved_flag == 1)
                                    Đã approve
                                    @elseif($contract->contract_approved_flag == 2)
                                    Đang đợi approve
                                    @else
                                    Đã bị reject
                                    @endif
                                </span>
                            </td>
                            <td style="">{{$contract->contract_created_at}}</td>
                            <td style="">{{!empty($contract->contract_updated_at)?$contract->contract_updated_at:"-"}}</td>
                            <td class="group-btn-contract-{{$contract->contract_id}}">@if(($contract->contract_status == 1 || $contract->contract_status == 2) && $contract->contract_approved_flag != 2)
                                <button class="btn btn-orange btn-custom-sm restore-contract restore-contract-{{$contract->contract_id}}" data-service="{{$contract->service_name}}" data-ship="{{$ship->detail_ship->ship_id}}" data-contract="{{$contract->contract_id}}">{{__('ship-contract.detail.btn_contract_restore')}}</button>
                                @endif
                                <a href="{{route('contract.edit', $contract->contract_id)}}" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_contract_edit')}}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="block-handle align-right">
                    <a href="/contract/create" class="btn btn-blue-dark btn-w190 pull-left">{{__('ship-contract.detail.btn_create')}}</a>
                    <button class="btn btn-gray-dark btn-w190 pull-left disable-contract" data-ship="{{$ship->detail_ship->ship_id}}">{{__('ship-contract.detail.btn_disable')}}</button>
                    <button class="btn btn-red btn-w150 pull-left delete-contract" data-ship="{{$ship->detail_ship->ship_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                </div>
            </div>
        </div>
        {{-- End List contract --}}
        @endif
        {{-- List Spot --}}
        @if(property_exists($ship, 'spots') && !is_null($ship->spots) && $ship->spots->count() > 0)
        <div class="spot-block">
            <h4>{{__('ship-contract.detail.lbl_ship_spot')}}</h4>
            <div class="content-block table-block spot-block">
                <div class="extra-block">{{__('ship-contract.detail.lbl_no_ship_spot', ['number' => $ship->spots->total()])}}</div>
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            <th style="width: 7%;">{{__('ship-contract.detail.lbl_spot_id')}}</th>
                            <th style="width: 13%;">{{__('ship-contract.detail.lbl_spot_name')}}</th>
                            <th style="width: 15%;">{{__('ship-contract.detail.lbl_spot_setting')}}</th>
                            <th style="width: 11%;">{{__('ship-contract.detail.lbl_spot_cost')}}</th>
                            <th style="width: 6%;">{{__('ship-contract.detail.lbl_spot_approve')}}</th>
                            <th style="width: 14%;">{{__('ship-contract.detail.lbl_spot_date_create')}}</th>
                            <th style="width: 20%;">{{__('ship-contract.detail.lbl_spot_date_update')}}</th>
                            <th style="width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ship->spots as $spot)
                        <tr>
                            <td style="word-wrap: break-word;">{{$spot->spot_id}}</td>
                            <td style="word-wrap: break-word;">{{$spot->spot_name}}</td>
                            <td style="word-wrap: break-word;">{{$spot->spot_month_usage}}</td>
                            <td>{{$spot->spot_amount_charge}}</td>
                            <td style="">
                                <span class="approve-spot-{{$spot->spot_id}}">
                                    @if($spot->spot_approved_flag == 1)
                                    Đã approve
                                    @elseif($spot->spot_approved_flag == 2)
                                    Đang đợi approve
                                    @else
                                    Đã bị reject
                                    @endif
                                </span>
                            </td>
                            <td style="">{{$spot->spot_created_at}}</td>
                            <td style="">{{$spot->spot_updated_at}}</td>
                            <td>
                                <a href="{{route('spot.edit', $spot->spot_id)}}" class="btn btn-blue-dark btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                                <button class="btn btn-red btn-custom-sm delete-spot" data-ship="{{$ship->detail_ship->ship_id}}" data-spot="{{$spot->spot_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="fl-block">
                    <div class="fl-page fl-left">
                        {{$ship->spots->links()}}
                    </div>
                    <div class="fl-page fl-right">
                        <div class="block-handle align-right">
                            <a href="#" class="btn btn-blue-light btn-w150">{{__('ship-contract.detail.btn_back')}}</a>
                            <a href="/spot/create" class="btn btn-green-dark btn-w150 pull-right">{{__('ship-contract.detail.btn_create')}}</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        {{-- End List Spot --}}
        @endif
    </div>
</div>
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">{{__('ship-contract.detail.lbl_popup_del_contract')}}</h4>
            </div>
            <div class="modal-body">
                <text id="modalMessage">{{__('ship-contract.detail.lbl_popup_del_contract_msg')}}</text>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w190" id="modalBtnOK">{{__('ship-contract.detail.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-done" tabindex="-1" role="dialog">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleDone">{{__('ship-contract.detail.lbl_popup_del_contract')}}</h4>
            </div>
            <div class="modal-body">
                <text id="modalMessageDone">{{__('ship-contract.detail.lbl_popup_del_contract_msg')}}</text>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_cancel')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('js/ship-contract.js') }}"></script>
@endsection