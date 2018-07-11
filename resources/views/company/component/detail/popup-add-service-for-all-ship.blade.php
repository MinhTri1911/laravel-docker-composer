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
                        <div class="alert alert-danger alert-service-id" style="display: none;">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label lbl-error-message service-id"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-start-date" style="display: none;">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label lbl-error-message start-date"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-end-date" style="display: none;">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label lbl-error-message end-date"></label>
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
                                @php
                                    $servicesData = [];
                                    $selected = $services->isNotEmpty() ? $services->first()->id : null;
                                    foreach ($services as $service) {
                                        $servicesData[$service->id] = $service->name_jp;
                                    }
                                @endphp
                                {{ Form::select('service-id', $servicesData, $selected, [
                                        'class' => 'form-control', 'require' => true,
                                        'id' => 'slb-service-id',
                                    ])
                                }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"></div>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <label class="label-control">{{ trans('company.lbl_contract_start_date') . ':' }}</label>
                        </div>
                        <div class="col-md-6">

                            <div class="group-datepicker">
                                {{ Form::text('contract-start-date', null, [
                                        'class' => 'form-control custom-datepicker',
                                        'id' => 'contract-start-date',
                                        'placeholder' => trans('company.lbl_contract_start_date'),
                                        'require' => true,
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
                            <label class="label-control">{{ trans('company.lbl_contract_end_date') . ':' }}</label>
                        </div>
                        <div class="col-md-6">

                            <div class="group-datepicker">
                                {{ Form::text('contract-end-date', null, [
                                        'class' => 'form-control custom-datepicker',
                                        'id' => 'contract-end-date',
                                        'placeholder' => trans('company.lbl_contract_end_date'),
                                        'require' => true,
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
                {{ Form::button(trans('company.btn_add_service'), [
                        'class' => 'center-block btn btn-blue-dark btn-w150',
                        'id' => 'btn-create-contract',
                    ])
                }}
            </div>
        </div>
    </div>
</div>
