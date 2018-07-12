@extends('layouts.white')

@section('title', __('ship-contract.detail.header_ship_contract'))

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
                <button class="btn btn-red btn-w150 delete-ship" data-ship="{{$ship->detail_ship->ship_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                <a href="{{route('ship.edit', $ship->detail_ship->ship_id)}}" class="btn btn-orange btn-w150">{{__('ship-contract.detail.btn_edit_ship')}}</a>
            </div>
        </div>
        {{-- End of ship block --}}
        @if(property_exists($ship, 'contracts') && !is_null($ship->contracts) )
        {{-- List contract --}}
        <div class="contract-block">
            <h4>{{__('ship-contract.detail.lbl_ship_contract')}}</h4>
            <div class="content-block table-block">
                <div class="extra-block">{{__('ship-contract.detail.lbl_no_ship_contract', ['number' => $ship->contracts->count()])}}</div>
                <table class="table table-blue table-ship">
                    <thead>
                        <tr>
                            
                            <th style="width:3%" class="custom-checkbox">
                                @if( $ship->contracts->count() > 0)
                                <input class="hidden" id="chk_ct_full" type="checkbox">
                                <label for="chk_ct_full"></label>
                                @endif
                            </th>
                            <th style="width:5%">{{__('ship-contract.detail.lbl_contract_id')}}</th>
                            <th style="width:5%">{{__('ship-contract.detail.lbl_contract_version')}}</th>
                            <th style="width:20%">{{__('ship-contract.detail.lbl_contract_service')}}</th>
                            <th style="width:7%">{{__('ship-contract.detail.lbl_contract_start')}}</th>
                            <th style="width:7%">{{__('ship-contract.detail.lbl_contract_end')}}</th>
                            <th style="width:10%">{{__('ship-contract.detail.lbl_contract_status')}}</th>
                            <th style="width:10%">{{__('ship-contract.detail.lbl_contract_approve')}}</th>
                            <th style="width:10%">{{__('ship-contract.detail.lbl_contract_date_create')}}</th>
                            <th style="width:10%">{{__('ship-contract.detail.lbl_contract_date_update')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( $ship->contracts->count() > 0)
                            @foreach($ship->contracts as $contract)
                            <tr>
                                <td class="custom-checkbox">
                                    <input class="hidden" id="chk_contract_{{$contract->contract_id}}" name="contract" type="checkbox">
                                    <label for="chk_contract_{{$contract->contract_id}}"></label>
                                </td>
                                <td style="word-wrap: break-word;">{{$contract->contract_id}}</td>
                                <td style="word-wrap: break-word;">{{(float)$contract->contract_revision_number}}</td>
                                <td style="word-wrap: break-word;">{{$contract->service_name}}</td>
                                <td style="">{{!is_null($contract->contract_date_start)&&!empty($contract->contract_date_start)?\Carbon\Carbon::parse($contract->contract_date_start)->format(\App\Common\Constant::FORMAT_DATE_TIME['d']):$contract->contract_date_start}}</td>
                                <td style="">{{!is_null($contract->contract_date_end)&&!empty($contract->contract_date_end)?\Carbon\Carbon::parse($contract->contract_date_end)->format(\App\Common\Constant::FORMAT_DATE_TIME['d']):$contract->contract_date_end}}</td>
                                <td>
                                    <span class="status-contract-{{$contract->contract_id}}">
                                        @if($contract->contract_status == 0)
                                            {{\App\Common\Constant::CONTRACT_O[0]}}
                                        @elseif($contract->contract_status == 1)
                                            {{\App\Common\Constant::CONTRACT_O[1]}}
                                        @else
                                            {{\App\Common\Constant::CONTRACT_O[2]}}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="approve-contract-{{$contract->contract_id}}">
                                        @if($contract->contract_approved_flag == 1)
                                            {{\App\Common\Constant::APPROVED_O[1]}}
                                        @elseif($contract->contract_approved_flag == 2)
                                            {{\App\Common\Constant::APPROVED_O[2]}}
                                        @else
                                        <text class="view-reason" data-type="contract" data-id="{{$contract->contract_id}}">
                                            {{\App\Common\Constant::APPROVED_O[3]}}
                                        </text>
                                        @endif
                                    </span>
                                </td>
                                <td style="">{{!is_null($contract->contract_created_at)&&!empty($contract->contract_created_at)?\Carbon\Carbon::parse($contract->contract_created_at)->format(\App\Common\Constant::FORMAT_DATE_TIME['dt']):$contract->contract_created_at}}</td>
                                <td style="">{{!is_null($contract->contract_updated_at)&&!empty($contract->contract_updated_at)?\Carbon\Carbon::parse($contract->contract_updated_at)->format(\App\Common\Constant::FORMAT_DATE_TIME['dt']):$contract->contract_updated_at}}</td>
                                <td class="group-btn-contract-{{$contract->contract_id}}">
                                    @if(($contract->contract_approved_flag == \App\Common\Constant::STATUS_APPROVED && $contract->contract_status != \App\Common\Constant::STATUS_CONTRACT_ACTIVE)
                                        || ($contract->contract_approved_flag == \App\Common\Constant::STATUS_WAITING_APPROVE && !is_null($contract->contract_updated_at))
                                        || ($contract->contract_approved_flag == \App\Common\Constant::STATUS_REJECT_APPROVE && !is_null($contract->contract_updated_at)))
                                        <button class="btn btn-blue-dark btn-custom-sm restore-contract restore-contract-{{$contract->contract_id}}" data-service="{{$contract->service_name}}" data-ship="{{$ship->detail_ship->ship_id}}" data-contract="{{$contract->contract_id}}">{{__('ship-contract.detail.btn_contract_restore')}}</button>
                                    @endif
                                    @if($contract->contract_approved_flag == \App\Common\Constant::STATUS_APPROVED
                                        || ($contract->contract_approved_flag == \App\Common\Constant::STATUS_WAITING_APPROVE && !is_null($contract->contract_updated_at))
                                        || $contract->contract_approved_flag == \App\Common\Constant::STATUS_REJECT_APPROVE)
                                            <a href="{{route('contract.edit', $contract->contract_id)}}" class="btn btn-orange btn-custom-sm">{{__('ship-contract.detail.btn_contract_edit')}}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="11">Chưa có hợp đồng được tạo</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="block-handle align-right">
                    <a href="/contract/create" class="btn btn-green-dark btn-w190 pull-left">{{__('ship-contract.detail.btn_create')}}</a>
                    @if( $ship->contracts->count() > 0)
                        <button class="btn btn-gray-dark btn-w190 pull-left disable-contract" data-ship="{{$ship->detail_ship->ship_id}}">{{__('ship-contract.detail.btn_disable')}}</button>
                        <button class="btn btn-red btn-w150 pull-left delete-contract" data-ship="{{$ship->detail_ship->ship_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                    @endif
                </div>
            </div>
        </div>
        {{-- End List contract --}}
        @endif
        
        {{-- List Spot --}}
        <div class="spot-block">
            @if(property_exists($ship, 'spots') && !is_null($ship->spots))
            <h4>{{__('ship-contract.detail.lbl_ship_spot')}}</h4>
            <div class="content-block table-block spot-block">
                <div class="extra-block">
                    <div class="pull-left">{{__('ship-contract.detail.lbl_no_ship_spot', ['number' => $ship->spots->total()])}}</div>
                    <div class="limit-block pull-right">
                        <span class="lbl_limit">{{__('ship-contract.detail.lbl_limit')}}</span>
                        <div class="custom-select" style="min-width:100px">
                            {{ Form::select('limit_page', \App\Common\Constant::ARY_PAGINATION_PER_PAGE, request()->filled('limit')?request()->get('limit'):null, ['class' => $ship->spots->count() > 0?'form-control limit-page':'form-control', 'tabindex' => 5]) }}
                        </div>
                    </div>
                </div>
                <div class="content-load">
                    <table class="table table-blue table-ship">
                        <thead>
                            <tr>
                                <th style="width: 5%;">{{__('ship-contract.detail.lbl_spot_id')}}</th>
                                <th style="width: 13%;">{{__('ship-contract.detail.lbl_spot_name')}}</th>
                                <th style="width: 15%;">{{__('ship-contract.detail.lbl_spot_setting')}}</th>
                                <th style="width: 11%;">{{__('ship-contract.detail.lbl_spot_cost')}}</th>
                                <th style="width: 10%;">{{__('ship-contract.detail.lbl_spot_approve')}}</th>
                                <th style="width: 14%;">{{__('ship-contract.detail.lbl_spot_date_create')}}</th>
                                <th style="width: 18%;">{{__('ship-contract.detail.lbl_spot_date_update')}}</th>
                                <th style="width: 20%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ship->spots->count() > 0)
                                @foreach($ship->spots as $spot)
                                <tr>
                                    <td style="word-wrap: break-word;">{{$spot->spot_id}}</td>
                                    <td style="word-wrap: break-word;">{{$spot->spot_name}}</td>
                                    <td style="word-wrap: break-word;">{{!is_null($spot->spot_month_usage)&&!empty($spot->spot_month_usage)?\Carbon\Carbon::parse($spot->spot_month_usage)->format(\App\Common\Constant::FORMAT_DATE_TIME['d']):$spot->spot_month_usage}}</td>
                                    <td>{{$spot->spot_amount_charge}}</td>
                                    <td style="">
                                        <span class="approve-spot-{{$spot->spot_id}}">
                                            @if($spot->spot_approved_flag == 1)
                                                {{\App\Common\Constant::APPROVED_O[1]}}
                                            @elseif($spot->spot_approved_flag == 2)
                                                {{\App\Common\Constant::APPROVED_O[2]}}
                                            @else
                                            <text class="view-reason" data-type="spot" data-id="{{$spot->spot_id}}">
                                                {{\App\Common\Constant::APPROVED_O[3]}}
                                            </text>
                                            @endif
                                        </span>
                                    </td>
                                    <td style="">{{!is_null($spot->spot_created_at)&&!empty($spot->spot_created_at)?\Carbon\Carbon::parse($spot->spot_created_at)->format(\App\Common\Constant::FORMAT_DATE_TIME['dt']):$spot->spot_created_at}}</td>
                                    <td style="">{{!is_null($spot->spot_updated_at)&&!empty($spot->spot_updated_at)?\Carbon\Carbon::parse($spot->spot_updated_at)->format(\App\Common\Constant::FORMAT_DATE_TIME['dt']):$spot->spot_updated_at}}</td>
                                    <td>
                                        @if((!empty($spot->spot_month_usage) && Str::checkValidMonthFromStr($spot->spot_month_usage))
                                            && (
                                                $spot->spot_approved_flag == \App\Common\Constant::STATUS_APPROVED
                                                    || ($spot->spot_approved_flag == \App\Common\Constant::STATUS_WAITING_APPROVE && !is_null($spot->spot_updated_at))
                                                    || $spot->spot_approved_flag == \App\Common\Constant::STATUS_REJECT_APPROVE))
                                            <a href="{{route('spot.edit', $spot->spot_id)}}" class="btn btn-orange btn-custom-sm">{{__('ship-contract.detail.btn_edit')}}</a>
                                            <button class="btn btn-red btn-custom-sm delete-spot" data-ship="{{$ship->detail_ship->ship_id}}" data-spot="{{$spot->spot_id}}">{{__('ship-contract.detail.btn_delete')}}</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="8">Chưa có phí spot nào được tạo</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="fl-block">
                        <div class="fl-page fl-right">
                            <div class="block-handle align-right">
                                <a href="{{route('ship.index', ['id' => $ship->detail_ship->ship_id])}}" class="btn btn-blue-light btn-w150">{{__('ship-contract.detail.btn_back')}}</a>
                                <a href="/spot/create" class="btn btn-green-dark btn-w150 pull-right">{{__('ship-contract.detail.btn_create')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="block-handle align-center block-page">
                        {{$ship->spots->appends($_GET)->render()}}
                    </div>
                </div>
            </div>
            {{-- End List Spot --}}
            @endif
        </div>
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
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-auth" tabindex="-1" role="dialog">
    <div class="modal-close">
        <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
        <label>閉じる</label>
    </div>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleAuth">{{__('ship-contract.detail.pop_auth_delete_ship')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <text id="modalMessageAuth">{{__('ship-contract.detail.lbl_input_pw')}}</text>
                    <input type="password" class="form-control" id="pw-user">
                    <input type="hidden" id="ship-id" value="{{$ship->detail_ship->ship_id}}">
                    <div id="ship-del-error" style="color:#ff0000"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('ship-contract.detail.btn_cancel')}}</button>
                <button type="button" class="btn btn-blue-dark btn-w190" id="modalBtnOKAuth">{{__('ship-contract.detail.btn_ok')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var ShipModal = {
        modalContractRestore: {
            title: "{{__('ship-contract.detail.pop_title_contract_re')}}",
            message: "{{__('ship-contract.detail.pop_message_contract_re')}}"
        },
        modalContractDelete: {
            title: "{{__('ship-contract.detail.pop_title_contract_del')}}",
            message: "{{__('ship-contract.detail.pop_message_contract_del')}}",
            title_error: "{{__('ship-contract.detail.pop_title_contract_error')}}",
            message_error: "{{__('ship-contract.detail.pop_message_contract_unselect')}}"
        },
        modalContractDisable: {
            title: "{{__('ship-contract.detail.pop_title_contract_dis')}}",
            message: "{{__('ship-contract.detail.pop_message_contract_dis')}}",
            title_error: "{{__('ship-contract.detail.pop_title_contract_error')}}",
            message_error: "{{__('ship-contract.detail.pop_message_contract_unselect')}}"
        },
        modalSpotDelete: {
            title: "{{__('ship-contract.detail.pop_title_spot_del')}}",
            message: "{{__('ship-contract.detail.pop_message_spot_del')}}"
        },
        modalShipDelete: {
            title: "{{__('ship-contract.detail.pop_title_ship_del')}}",
            message: "{{__('ship-contract.detail.pop_message_ship_del')}}"
        },
        modalAuth: {
            message_error_pw: "{{__('ship-contract.detail.pop_message_auth_pw')}}"
        },
        modalReject: {
            title: "{{__('ship-contract.detail.pop_title_reject')}}"
        },
        typo: {
            stt_active: "{{\App\Common\Constant::CONTRACT_O[0]}}",
            stt_pending: "{{\App\Common\Constant::CONTRACT_O[1]}}",
            stt_finish: "{{\App\Common\Constant::CONTRACT_O[2]}}",

            apv_done: "{{\App\Common\Constant::APPROVED_O[1]}}",
            apv_pending: "{{\App\Common\Constant::APPROVED_O[2]}}",
            apv_reject: "{{\App\Common\Constant::APPROVED_O[3]}}"
        }
    };
</script>
<script type="text/javascript" src="{{ asset('js/ship-contract.js') }}"></script>
@endsection