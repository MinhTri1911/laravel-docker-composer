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
                    <div class="col-md-3">
                        <label class="label-control">{{ trans('company.lbl_billing_method_name') }}</label>
                    </div>

                    <div class="col-md-6">
                        <div class="custom-select">
                            {{ Form::select('billing-method-id', [1 => 'ALL', 2 => 'ABC'], 1, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_cancel_setting_billing'), [
                        'class' => 'center-block btn btn-gray-dark btn-w150 btn-csv',
                        'data-dismiss' => 'modal'
                    ])
                }}
                {{ Form::button(trans('company.btn_save_setting_billing'), ['class' => 'center-block btn btn-blue-dark btn-w150']) }}
            </div>
        </div>
    </div>
</div>
