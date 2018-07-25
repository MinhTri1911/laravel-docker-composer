@if(isset($data) && count($data) > 0)
    @foreach($data as $contract)
        <div class="modal-header">
            <h4 class="modal-title">{{__('approve.header_pop_contract_detail')}}</h4>
        </div>
        <div class="modal-body">
            <div class="block-detail">
                <div class="split-col">
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
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_note')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_remark}}
                            </div>
                        </div>
                    </div>
                </div>
                @if(!is_null($contract->data_update) && $contract->data_update->contract_status == \App\Common\Constant::STATUS_CONTRACT_ACTIVE)
                <div class="@if(!is_null($contract->data_update))split-col @endif">
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
                            <div class="item-label">
                                {{__('approve.lbl_contract_note')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->data_update->contract_remark}}
                            </div>
                        </div>
                    </div>
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