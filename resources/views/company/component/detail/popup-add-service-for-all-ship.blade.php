<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_add_service') }}</h2>
        </div>
        <div class="modal-body">
            <div class="modal-setting-billing-content">
                <h2>{{ trans('company.lbl_add_service') }}</h2>

                <!--begin show errors-->
                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label">
                                    住所1を入力してください。
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end show errors-->

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="label-control">{{ trans('company.lbl_service_name') }}</label>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-select">
                                {{ Form::select('service-id', [1 => 'CMAXS-SPIC', 2 => 'CMAXS-PMS', 3 => 'CMAXS-ABLOG'], 1, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"></div>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="label-control">{{ trans('company.lbl_contract_start_date') }}</label>
                        </div>
                        <div class="col-md-6">

                            <div class="group-datepicker">
                                {{ Form::text('contract-start-date', null, [
                                        'class' => 'form-control custom-datepicker',
                                        'id' => 'datetime',
                                        'placeholder' => trans('company.lbl_contract_start_date'),
                                    ])
                                }}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"></div>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="label-control">{{ trans('company.lbl_contract_end_date') }}</label>
                        </div>
                        <div class="col-md-6">

                            <div class="group-datepicker">
                                {{ Form::text('contract-end-date', null, [
                                        'class' => 'form-control custom-datepicker',
                                        'id' => 'datetime',
                                        'placeholder' => trans('company.lbl_contract_end_date'),
                                    ])
                                }}
                                <span class="icon-picker"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_cancel_add_service'), [
                        'class' => 'center-block btn btn-gray-dark btn-w150 ',
                        'data-dismiss' => 'modal',
                    ])
                }}
                {{ Form::button(trans('company.btn_add_service'), ['class' => 'center-block btn btn-blue-dark btn-w150']) }}
            </div>
        </div>
    </div>
</div>
