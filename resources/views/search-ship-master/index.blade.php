<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('contract.header_pop_ship')}}</h4>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="modal-left">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{__('contract.lbl_pop_ship_id')}}
                            </div>
                            <div class="item-value">
                                {!! Form::text('idShipSearch', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_pop_ship_id')]) !!}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('contract.lbl_pop_ship_name')}}
                            </div>
                            <div class="item-value">
                                {!! Form::text('nameShipSearch', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_pop_ship_name')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-right">
                    <div class="block-handle align-center" style="margin-top: 65px;">
                        <button class="btn btn-blue-light btn-w150" id='btn-search-ship'>{{__('contract.btn_pop_search')}}</button>
                    </div>
                </div>
            </div>
            <table id="table-content-search-ship"class="table table-blue table-service table-popup table-fixed">
                <thead>
                    <tr>
                        <th style="width: 20%" class='th-id-ship'>{{__('contract.lbl_pop_ship_id')}}</th>
                        <th style="width: 70%" class='th-name-ship'>{{__('contract.lbl_pop_ship_name')}}</th>
                        <th style="width: 10%" class='th-chosse-ship'></th>
                    </tr>
                </thead>
                <tbody class="tbody-popup" id="content-data-search-ship">

                </tbody>
            </table>          
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('contract.btn_pop_cancel')}}</button>
            <button type="button" class="btn btn-blue-dark btn-w190" data-dismiss="modal" id="btn-ok-ship">{{__('contract.btn_pop_ok')}}</button>
        </div>
    </div>
</div>