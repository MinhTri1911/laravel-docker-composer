@if(isset($data) && count($data) > 0)
    @foreach($data as $spot)
    <div class="modal-header">
            <h4 class="modal-title">{{__('approve.header_pop_spot_detail')}}</h4>
        </div>
        <div class="modal-body">
            <div class="block-detail">
                <div class="@if(!is_null($spot->data_update))split-col @endif">
                    @if(!is_null($spot->data_update) && $spot->data_update->spot_del_flag == \App\Common\Constant::DELETE_FLAG_FALSE)
                    <h4>{{__('approve.lbl_old_content')}}:</h4>
                    @endif
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_id')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_id}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_ship')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_ship_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_company')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_company_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_curency')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_currency_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_type')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_spot_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_monnth_usage')}}
                            </div>
                            <div class="item-value">
                                : {{!is_null($spot->spot_month_usage)?\Carbon\Carbon::parse($spot->spot_month_usage)->format('Y/m'):''}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_cost')}}
                            </div>
                            <div class="item-value">
                                : {{Str::convertMoneyComma($spot->spot_amount_charge)}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_note')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->spot_remark}}
                            </div>
                        </div>
                    </div>
                </div>
                @if(!is_null($spot->data_update) && $spot->data_update->spot_del_flag == \App\Common\Constant::DELETE_FLAG_FALSE)
                <div class="split-col">
                    <h4>{{__('approve.lbl_new_content')}}:</h4>
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_id')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_id}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_ship')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_ship_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_company')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_company_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_curency')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_currency_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_type')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_spot_name}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_monnth_usage')}}
                            </div>
                            <div class="item-value">
                                : {{!is_null($spot->data_update->spot_month_usage)?\Carbon\Carbon::parse($spot->data_update->spot_month_usage)->format('Y/m'):''}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_cost')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_amount_charge}}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('approve.lbl_spot_note')}}
                            </div>
                            <div class="item-value">
                                : {{$spot->data_update->spot_remark}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
         </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('approve.btn_close')}}</button>
            @if($spot->spot_approved_flag != \App\Common\Constant::STATUS_REJECT_APPROVE)
            <button type="button" class="btn btn-red btn-w150 btn-reject" data-type="1">{{__('approve.btn_reject')}}</button>
            <button type="button" class="btn btn-blue-dark btn-w150 btn-approve" data-type="1">{{__('approve.btn_approve')}}</button>
            @endif
        </div>
    @endforeach
@endif
