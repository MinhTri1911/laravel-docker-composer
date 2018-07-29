<div class="modal-close">
    <button class="btn-close-modal" style="background-image: url('https://mufmgr.schl.jp/images/common/modals_close.png')" data-dismiss="modal"></button>
    <label>閉じる</label>
</div>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="popup-title">
            <h2>{{ trans('company.title_popup_detail_company') }}</h2>
        </div>
        <div class="modal-body">
            <div class="table-detail-group">
                <table class="table table-blue table-dropdown table-result table-popup">
                    <thead>
                        <tr>
                            <th class="col-xs-2">
                                {{ trans('company.header_company_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_system_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_ship_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_start_date') }}
                            </th>
                            <th class="col-xs-2">
                                Status
                            </th>
                        </tr>
                    </thead>
                </table>

                <div class="detail-group-table">
                    <table class="table table-blue table-result table-popup">
                        @if ($detailGroup->isNotEmpty())
                            <tbody>
                                <tr>

                                    <!-- Show first row detail -->
                                    <td rowspan="{{ $detailGroup->count() + 1 }}" class="col-xs-2">{{ $detailGroup->first()->company_jp }}</td>
                                </tr>

                                <!-- Init variable for count row span and tracker row for group -->
                                @php $count = 1; $tracker = []; @endphp

                                <!-- Loop result -->
                                @foreach ($detailGroup as $index => $company)
                                    @php
                                        $status;
                                        
                                        if ($company->contract_status == 0 && $company->contract_approve == 1) {
                                            $status = 'Active';
                                        } elseif ($company->contract_status == 0 && $company->contract_approve == 2) {
                                            $status = 'Create New';
                                        } elseif ($company->contract_status == 0 && $company->contract_approve == 3) {
                                            $status = 'Reject create';
                                        } elseif ($company->contract_status == 1 && $company->contract_approve == 1) {
                                            $status = 'Pedding';
                                        } elseif ($company->contract_status == 1 && $company->contract_approve == 2) {
                                            $status = 'Pedding Watting Approve';
                                        } elseif ($company->contract_status == 2) {
                                            $status = 'Het han';
                                        } elseif ($company->contract_status == 3) {
                                            $status = 'Da bi xoa';
                                        } elseif ($company->contract_status == null && $company->contract_approve == null) {
                                            $status = 'N/A';
                                        }
                                    @endphp
                                    <!-- Count rowspan and tracker for group -->
                                    @for ($i = $index + 1; $i < $detailGroup->count(); $i++)

                                        <!-- Check service id was tracked, if not count + 1 and mark service is tracked for group -->
                                        @if ($detailGroup[$i]->service_id === $detailGroup[$index]->service_id && !in_array($i, $tracker))
                                            @php $count++; $tracker[] = $i; @endphp
                                        @else

                                            <!-- Break loop if service[i] != service[index] -->
                                            @break
                                        @endif
                                    @endfor

                                    <!-- Check service[index] was tracked, if not add rowspan -->
                                    @if (!in_array($index, $tracker))
                                        <tr>
                                            <td rowspan="{{ $count }}" class="col-xs-2">{{ $company->service_jp }}</td>
                                            <td class="col-xs-2">{{ $company->ship_name }}</td>
                                            <td class="col-xs-2">{{ $company->contract_start_date }}</td>
                                            <td class="col-xs-2">{{ $status }}</td>
                                        </tr>

                                    <!-- Check service[index] was tracked -->
                                    @elseif (in_array($index, $tracker))
                                        <tr>
                                            <td class="col-xs-2">{{ $company->ship_name }}</td>
                                            <td class="col-xs-2">{{ $company->contract_start_date }}</td>
                                            <td class="col-xs-2">{{ $status }}</td>
                                        </tr>

                                        <!-- Check id service[index] != id service[index + 1] and reset variabel count and tracker -->
                                        @if ($index == $detailGroup->count() - 1 || $company->service_id !== $detailGroup[$index + 1]->service_id)
                                            @php $count = 1; $tracker = []; @endphp
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_close_popup'), ['class' => 'center-block btn btn-gray-dark btn-w150 btn-csv', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>
