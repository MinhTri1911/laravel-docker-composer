<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_setting_billing_method') }}</h2>
        </div>
        <div class="modal-body">
            <div class="modal-setting-billing-content">
                <h2>{{ trans('company.lbl_setting_billing_method') }}</h2>

                <div class="setting-content">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            <div class="block-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                <label class="control-label lbl-error-message"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="setting-content">
                    <div class="col-md-3">
                        <label class="label-control">{{ trans('company.lbl_billing_method_name') }}</label>
                    </div>

                    <div class="col-md-6">
                        <div class="custom-select">

                            {{-- Load all billing methd to array and set selected if billing method id == $id ($id is current billing method id)  --}}
                            @php
                                $dataAppend = [];
                                $dataBilings = [];
                                foreach ($billings as $billing) {
                                    $dataBilings[$billing->id] = $billing->name_jp . ' ' . $billing->id;
                                    $dataAppend[$billing->id] = [
                                        'jp' => $billing->name_jp,
                                        'en' => $billing->name_en,
                                    ];
                                }
                            @endphp
                            {{ Form::select('billing-method-id', $dataBilings, $id, ['class' => 'form-control', 'id' => 'slb-billing-method']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_cancel_setting_billing'), [
                        'class' => 'center-block btn btn-gray-dark btn-w150 btn-csv',
                        'data-dismiss' => 'modal',
                    ])
                }}
                {{ Form::button(trans('company.btn_save_setting_billing'), [
                    'class' => 'center-block btn btn-blue-dark btn-w150',
                    'id' => 'btn-save-setting-billing',
                    'data-for-append' => json_encode($dataAppend),
                ]) }}
            </div>
        </div>
    </div>
</div>
