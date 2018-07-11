<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url({{url('images/common/modals_close.png')}})" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{__('contract.header_pop_service')}}</h4>
        </div>
        <div class="modal-body">
            <div class="modal-row">
                <div class="modal-left">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="item-label">
                                {{__('contract.lbl_pop_service_id')}}
                            </div>
                            <div class="item-value">
                                {!! Form::text('idServiceSearch', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_pop_service_id')]) !!}
                            </div>
                        </div>
                        <div class="item-row">
                            <div class="item-label">
                                {{__('contract.lbl_pop_service_name')}}
                            </div>
                            <div class="item-value">
                                {!! Form::text('nameServiceSearch', null, ['class' => 'form-control', 'placeholder' => __('contract.lbl_pop_service_name')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-right">
                    <div class="table-block">
                        <div class="item-row">
                            <div class="block-handle align-center" style="margin-top: 65px;">
                                <button class="btn btn-blue-light btn-w150" id='btn-search'>{{__('contract.btn_pop_search')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="table-content-search-sv"class="table table-blue table-service table-popup table-fixed">
                <thead>
                    <tr>
                        <th style="width: 20%">{{__('contract.lbl_pop_service_id')}}</th>
                        <th style="width: 70%">{{__('contract.lbl_pop_service_name')}}</th>
                        <th style="width: 10%"></th>
                    </tr>
                </thead>
                <tbody class="tbody-popup" id="content-data-search">

                </tbody>
            </table>          
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue-light btn-w150" data-dismiss="modal">{{__('contract.btn_pop_cancel')}}</button>
            <button type="button" class="btn btn-blue-dark btn-w190" data-dismiss="modal" id="btn-ok">{{__('contract.btn_pop_ok')}}</button>
        </div>
    </div>
</div>