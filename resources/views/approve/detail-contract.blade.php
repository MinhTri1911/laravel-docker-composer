@if(isset($data['contracts']) && count($data['contracts']) > 0)
    @foreach($data['contracts'] as $contract)
        <div class="modal-header">
            <h4 class="modal-title">{{__('approve.header_pop_contract_detail')}}</h4>
        </div>
        <div class="modal-body">
            <div class="block-detail">
                <div class="@if(!is_null($contract->data_update)) split-col @endif">
                    @if(!is_null($contract->data_update) && $contract->data_update->contract_status == \App\Common\Constant::STATUS_CONTRACT_ACTIVE)
                    <h4>{{__('approve.lbl_old_content')}}:</h4>
                    @endif
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_id')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_id}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_ship')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_ship_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_service')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_service_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_company')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_company_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_start')}}
                            </div>
                            <div class="item-value">
                                : {{!is_null($contract->contract_start_date)?\Carbon\Carbon::parse($contract->contract_start_date)->format('Y/m/d'):null}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_end')}}
                            </div>
                            <div class="item-value">
                                : {{!is_null($contract->contract_end_date)?\Carbon\Carbon::parse($contract->contract_end_date)->format('Y/m/d'):null}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_status')}}
                            </div>
                            <div class="item-value">
                                : {{\App\Common\Constant::CONTRACT_O[$contract->contract_status]}}
                            </div>
                        </div>
                        <div class="item-row" style="vertical-align: top;">
                            <div class="item-label">
                                {{__('approve.lbl_contract_note')}}
                            </div>
                            <div class="item-value">
                                : <div class="fr-max">{{$contract->contract_remark}}</div>
                            </div>
                        </div>
                    </div>
                    {{--Show spot block--}}
                    @if(isset($data['spots']) && !is_null($data['spots']) && count($data['spots']) > 0 && is_null($contract->data_update))
                        <div class="item-row" style="vertical-align: top;">
                            <table class="table table-blue">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"></th>
                                        <th style="width: 55%;">{{__('contract.lbl_type_spot')}}</th>
                                        <th style="width: 40%;">{{__('contract.lbl_cost_spot')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['spots'] as $spot)
                                    <tr>
                                        <td class="custom-checkbox">
                                            <input class="hidden spot-in-contract" id="chk_ct_spot_{{$spot->spot_id}}" data-spot-contract='{{$spot->spot_id}}' type="checkbox" checked="checked">
                                            <label for="chk_ct_spot_{{$spot->spot_id}}"></label>
                                        </td>
                                        <td>{{$spot->spot_spot_name}}</td>
                                        <td>{{Str::convertMoneyComma($spot->spot_amount_charge)}}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    @endif
                    {{--End show spot block--}}
                </div>
                @if(!is_null($contract->data_update) && $contract->data_update->contract_status == \App\Common\Constant::STATUS_CONTRACT_ACTIVE && $contract->data_update->contract_del_flag == 0)
                <div class="split-col">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                <h4>{{__('approve.lbl_new_content')}}:</h4>
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_id')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_id}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_ship')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_ship_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_service')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_service_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_company')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_company_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_start')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_start_date}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_end')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_end_date}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_status')}}
                            </div>
                            <div class="item-value">
                                : {{\App\Common\Constant::CONTRACT_O[$contract->data_update->contract_status]}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label" style="vertical-align: top;">
                                {{__('approve.lbl_contract_note')}}
                            </div>
                            <div class="item-value">
                                :  <div class="fr-max">{{$contract->data_update->contract_remark}}</div>
                            </div>
                        </div>
                    </div>
                    {{--Show spot block--}}
                    @if(isset($data['spots']) && !is_null($data['spots']) && count($data['spots']) > 0)
                        <div class="item-row" style="vertical-align: top;">
                            <table class="table table-blue">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;"></th>
                                        <th style="width: 55%;">{{__('contract.lbl_type_spot')}}</th>
                                        <th style="width: 40%;">{{__('contract.lbl_cost_spot')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['spots'] as $spot)
                                    <tr>
                                        <td class="custom-checkbox">
                                            <input class="hidden spot-in-contract" id="chk_ct_spot_{{$spot->spot_id}}" data-spot-contract='{{$spot->spot_id}}' type="checkbox" checked="checked">
                                            <label for="chk_ct_spot_{{$spot->spot_id}}"></label>
                                        </td>
                                        <td>{{$spot->spot_spot_name}}</td>
                                        <td>{{Str::convertMoneyComma($spot->spot_amount_charge)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    {{--End show spot block--}}
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_close')}}</button>
            @if($contract->contract_approved_flag != \App\Common\Constant::STATUS_REJECT_APPROVE)
            <button type="button" class="btn btn-red btn-w150 btn-reject" data-type="0">{{__('approve.btn_reject')}}</button>
            <button type="button" class="btn btn-blue-dark btn-w150 btn-approve" data-type="0">{{__('approve.btn_approve')}}</button>
            @endif
        </div>
    @endforeach
@endif