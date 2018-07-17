<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog" id="modal-stack-one">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_delete_service') }}</h2>
        </div>
        <div class="modal-body">
            <h2>{{ trans('company.lbl_delete_service') }}</h2>
            <div class="modal-setting-billing-content">
                <div class="setting-content">
                    <table class="table table-blue table-fixed">
                        <thead>
                            <tr>
                                <th class="col-xs-1">ID</th>
                                <th class="col-xs-8">{{ trans('company.lbl_head_service') }}</th>
                                <th class="col-xs-3">{{ trans('company.lbl_head_action_delete') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody-scroll">
                            @foreach ($services as $service)
                                <tr>
                                    <td class="col-xs-1">
                                        {{ $service->service_id }}
                                    </td>
                                    <td class="col-xs-8">
                                        {{ $service->name_jp }}
                                    </td>
                                    <td class="col-xs-3">
                                        <a data-toggle="modal"
                                            href="#popup-confirm-delete-service"
                                            class="delete-service-label"
                                            id="delete-service-{{ $service->service_id }}"
                                            data-url="{{ route('company.service.confirmDelete', [
                                                    'name' => $service->name_jp,
                                                    'id' => $service->service_id,
                                                ])
                                            }}">
                                            {{ trans('company.lbl_action_delete') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ Form::button(trans('company.btn_close_popup_delete_service'), ['class' => 'btn btn-gray-dark btn-w150 btn-csv btn-right', 'data-dismiss' => 'modal']) }}
                </div>
            </div>
        </div>
    </div>
</div>
