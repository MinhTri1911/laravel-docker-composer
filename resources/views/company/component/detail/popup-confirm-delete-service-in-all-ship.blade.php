<div class="modal-dialog">
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_confirm_delete_service') }}</h2>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <h2 class="block-center">{{ $serviceName . ' ' . trans('company.confirm_message') }}</h2>
            </div>
            <div class="modal-stack-bottom">
                {{ Form::button(trans('company.btn_cancel_delete'), [
                        'class' => 'center-block btn btn-gray-dark btn-w150 close-modal',
                        'data-dismiss' => 'modal',
                    ])
                }}
                {{ Form::button(trans('company.btn_delete'), [
                        'id' => "btn-delete-service",
                        'class' => "center-block btn btn-red btn-w150 close-modal",
                        'data-id' => $serviceId,
                    ])
                }}
            </div>
        </div>
    </div>
</div>
