<!-- Title table -->
<div class="block-title-tbl">
    <div class="left-side">
        <label class="label-control">{{__('tax.lbl_count_record_1') . $model['resultSearch']->total() . __('tax.lbl_count_record_2')}}</label>
        {{ Form::hidden('total_record', $model['resultSearch']->total(), [ 'id' => 'total-record'])}}
    </div>
    <div class="right-side">
        <div class="form-group">
            <div class="left-side">
                <label class="label-control">{{__('tax.lbl_number_record_display')}}</label>
            </div>
            <div class="right-side">
                <div class="custom-select">
                    {!! Form::select(0, $model['numberRecord'], null, ['class' => 'form-control', 'id' => 'slt-number-record']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!--Table tax master-->
<div id="block-tbl-tax">
    <table class="table table-blue table-list-master resizable">
        <thead>
            <tr>
                <th class="tbl-row-no">{{__('tax.tbl_list_tax_header.id')}}</th>
                <th class="tbl-row-company-name">{{__('tax.tbl_list_tax_header.rate')}}</th>
                <th class="tbl-row-date">{{__('tax.tbl_list_tax_header.remark')}}</th>
                <th lass="tbl-row-method">{{__('tax.tbl_list_tax_header.created_at')}}</th>
                <th>{{__('tax.tbl_list_tax_header.updated_at')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($model['resultSearch'] as $row)
                <tr>
                    <td class="tbl-row-no">{{ $loop->iteration}}</td>
                    <td class="tbl-row-company-name">{{ $row->company_name }}</td>
                    <td class="tbl-row-date">{{ $row->payment_deadline_month }}</td>
                    <td class="tbl-row-method">{{ $row->method_name }}</td>
                    <td class="tbl-row-ope-name">{{ $row->ope_person_name_1 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-md-12" id="area-paginate" class="clear-both">
    @include('tax.component.paginate.default')
</div>
