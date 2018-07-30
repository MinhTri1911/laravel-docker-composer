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
            <div class="table-detail-group">
                <table class="table table-blue table-dropdown table-result table-popup">
                    <thead>
                        <tr>
                            <th class="col-xs-2">
                                {{ trans('company.header_system_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_company_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_ship_name') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_contract_status') }}
                            </th>
                            <th class="col-xs-2">
                                {{ trans('company.header_contract_approve') }}
                            </th>
                            <th class="col-xs-4">
                                {{ trans('company.header_start_date') }}
                            </th>
                        </tr>
                    </thead>

                </table>

                <div class="detail-group-table">
                    <table class="table table-blue table-result table-popup">
                        <tbody>
                            <!-- Init variable for count row span and tracker row for group -->
                            @php $count = 1; $tracker = []; @endphp
                            <tr>

                                <!-- Show first row detail -->
                                <td rowspan="{{ $detailGroup->count() + 1 }}" class="col-xs-2">{{ $detailGroup->first()->service_jp }}</td>
                            </tr>

                            <!-- Loop result -->
                            @foreach ($detailGroup as $index => $service)

                                <!-- Count rowspan and tracker for group -->
                                @for ($i = $index + 1; $i < $detailGroup->count(); $i++)

                                    <!-- Check company id was tracked, if not count + 1 and mark company is tracked for group -->
                                    @if ($detailGroup[$i]->company_id === $detailGroup[$index]->company_id && !in_array($i, $tracker))
                                        @php $count++; $tracker[] = $i; @endphp
                                    @else

                                        <!-- Break loop if company[i] != company[index] -->
                                        @break
                                    @endif
                                @endfor

                                <!-- Check company[index] was tracked, if not add rowspan -->
                                @if (!in_array($index, $tracker))
                                    <tr>
                                        <td rowspan="{{ $count }}" class="col-xs-2">{{ $service->company_jp }}</td>
                                        <td class="col-xs-2">{{ $service->ship_name }}</td>
                                        <td class="col-xs-2">{{ @Constant::CONTRACT_O[$service->contract_status] }}</td>
                                        <td class="col-xs-2">{{ @Constant::APPROVED_O[$service->contract_approve] }}</td>
                                        <td class="col-xs-4">{{ $service->contract_start_date }}</td>
                                    </tr>

                                <!-- Check company[index] was tracked -->
                                @elseif (in_array($index, $tracker))
                                    <tr>
                                        <td class="col-xs-2">{{ $service->ship_name }}</td>
                                        <td class="col-xs-2">{{ @Constant::CONTRACT_O[$service->contract_status] }}</td>
                                        <td class="col-xs-2">{{ @Constant::APPROVED_O[$service->contract_approve] }}</td>
                                        <td class="col-xs-4">{{ $service->contract_start_date }}</td>
                                    </tr>

                                    <!-- Check id company[index] != id company[index + 1] and reset variabel count and tracker -->
                                    @if ($index == $detailGroup->count() - 1 || $service->company_id !== $detailGroup[$index + 1]->company_id)
                                        @php $count = 1; $tracker = []; @endphp
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_close_popup'), ['class' => 'center-block btn btn-gray-dark btn-w150 btn-csv', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>
