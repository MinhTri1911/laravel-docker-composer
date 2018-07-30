{{-- Table head --}}
<table class="table table-blue table-result resizable">
    <thead>
        <tr>
            <th class="col-ship-name">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_ship_name') }}
                    <i class="fa fa-sort" data-sort="filter-ship-name"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-ship-name', null, ['class' => 'form-control', 'tabindex' => 3]) }}
                </div>
            </th>
            <th class="col-company-name">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_company_name') }}
                    <i class="fa fa-sort" data-sort="filter-company"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-company', null, ['class' => 'form-control', 'tabindex' => 4]) }}
                </div>
            </th>
            <th class="col-classification">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_classification') }}
                    <i class="fa fa-sort" data-sort="filter-classification"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-classification', null, ['class' => 'form-control', 'tabindex' => 5]) }}
                </div>
            </th>
            <th class="col-ship-type">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_ship_type') }}
                    <i class="fa fa-sort" data-sort="filter-ship-type"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-ship-type', null, ['class' => 'form-control', 'tabindex' => 6]) }}
                </div>
            </th>
            <th class="col-imo-number">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_imo_number') }}
                    <i class="fa fa-sort" data-sort="filter-imo-number"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-imo-number', null, ['class' => 'form-control', 'tabindex' => 7]) }}
                </div>
            </th>
            <th class="col-ship-nation">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_ship_nation') }}
                    <i class="fa fa-sort" data-sort="filter-ship-nation"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-ship-nation', null, ['class' => 'form-control', 'tabindex' => 8]) }}
                </div>
            </th>
            <th class="col-service">
                <div class="th-line-one">
                    {{ trans('ship.lbl_title_service_name') }}
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-service-name', null, ['class' => 'form-control', 'tabindex' => 9]) }}
                </div>
            </th>
            <th class="col-action contract-status">
                {{ trans('ship.contract_status') }}
            </th>
            <th class="col-action approve-status">
                {{ trans('billing.tbl_list_company_header.status_approve') }}
            </th>
            <th class="col-action">
                {{ Form::button(
                    trans('ship.btn_filter'),
                    [
                        'class' => 'btn btn-blue-dark btn-custom-sm',
                        'tabindex' => 10,
                        'id' => 'btn-filter',
                        'data-url' => route('ship.filter')
                    ]
                ) }}
            </th>
        </tr>
    </thead>
    @php $totalResult = $ships->total(); @endphp
    <tbody class="table-content" data-total="{{ trans('ship.lbl_total_result', ['total' => $totalResult]) }}">
        @include('ship.component.list.table-data')
    </tbody>
</table>