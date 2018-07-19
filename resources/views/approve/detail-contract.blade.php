@if(isset($data) && count($data) > 0)
    @foreach($data as $contract)
        <div class="modal-header">
            <h4 class="modal-title">{{__('approve.header_pop_contract_detail')}}</h4>
        </div>
        <div class="modal-body">
            <div class="block-detail">
                @if(!is_null($contract->data_update))
                <div class="split-col">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                <h4>Nội dung cũ:</h4>
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
                <div class="@if(!is_null($contract->data_update))split-col @endif">
                    <h4>Nội dung mới:</h4>
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
                                : {{$contract->contract_start_date}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_contract_end')}}
                            </div>
                            <div class="item-value">
                                : {{$contract->contract_end_date}}
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
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_close')}}</button>
            @if($contract->contract_approved_flag != \App\Common\Constant::STATUS_REJECT_APPROVE)
            <button type="button" class="btn btn-blue-dark btn-w150 btn-approve" data-type="0">{{__('approve.btn_approve')}}</button>
            <button type="button" class="btn btn-red btn-w150 btn-reject" data-type="0">{{__('approve.btn_reject')}}</button>
            @endif
        </div>
    @endforeach
@endif