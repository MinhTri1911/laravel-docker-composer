<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_detail_system') }}</h2>
        </div>
        <div class="modal-body">
            <div>
                <table class="table table-blue table-dropdown">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('company.header_system_name') }}
                            </th>
                            <th>
                                {{ trans('company.header_company_name') }}
                            </th>
                            <th>
                                {{ trans('company.header_ship_name') }}
                            </th>
                            <th>
                                {{ trans('company.header_start_date') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="3">CMAXS-PMS</td>
                            <td rowspan="2">AAA海運</td>
                            <td>A丸</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>B丸</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="1">BBB海運</td>
                            <td>C丸</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_close_popup'), ['class' => 'center-block btn btn-gray-dark btn-w150 btn-csv', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>
