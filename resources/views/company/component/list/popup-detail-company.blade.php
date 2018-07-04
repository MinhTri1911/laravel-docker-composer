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
                <table class="table table-blue table-dropdown">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('company.header_company_name') }}
                            </th>
                            <th>
                                {{ trans('company.header_system_name') }}
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
                            <td rowspan="{{ $detailGroup->count() + 1 }}">{{ $detailGroup->first()->company_jp }}</td>
                        </tr>
                        @php $count = 1; $tracker = []; @endphp
                        @foreach ($detailGroup as $index => $company)
                            @for ($i = $index + 1; $i < $detailGroup->count(); $i++)
                                @if ($detailGroup[$i]->service_id === $detailGroup[$index]->service_id && !in_array($i, $tracker))
                                    @php $count++; $tracker[] = $i; @endphp
                                @else
                                    @break
                                @endif
                            @endfor
                            @if (!in_array($index, $tracker))
                                <tr>
                                    <td rowspan="{{ $count }}">{{ $company->service_jp }}</td>
                                    <td>{{ $company->ship_name }}</td>
                                    <td>{{ $company->contract_start_date }}</td>
                                </tr>
                            @elseif (in_array($index, $tracker))
                                <tr>
                                    <td>{{ $company->ship_name }}</td>
                                    <td>{{ $company->contract_start_date }}</td>
                                </tr>
                                @if ($index == $detailGroup->count() - 1 || $company->service_id !== $detailGroup[$index + 1]->service_id)
                                    @php $count = 1; $tracker = []; @endphp
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-bottom">
                {{ Form::button(trans('company.btn_close_popup'), ['class' => 'center-block btn btn-gray-dark btn-w150 btn-csv', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>
