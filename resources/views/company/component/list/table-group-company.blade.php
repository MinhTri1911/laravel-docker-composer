<table class="table table-blue table-result resizable">
    <thead>
        <tr>
            <th class="th-checkbox col-checkbox">
                <div class="th-line-one">
                </div>
                <div class="th-line-two custom-checkbox">
                    {{ Form::checkbox('cb-all', 1, false, ['id' => 'cb-all', 'tabindex' => 4]) }}
                    <label for="cb-all"></label>
                </div>
            </th>
            <th class="col-company-name" id="demo">
                <div class="th-line-one">
                    {{ trans('company.header_company_name') }}
                    <i class="fa fa-sort" data-sort="filter-company"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-company', null, ['class' => 'form-control', 'tabindex' => 5]) }}
                </div>
            </th>
            <th class="col-company-nation">
                <div class="th-line-one">
                    {{ trans('company.header_company_national') }}
                    <i class="fa fa-sort" data-sort="filter-nation"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-nation', null, ['class' => 'form-control', 'tabindex' => 6]) }}
                </div>
            </th>
            <th class="col-office-address">
                <div class="th-line-one">
                    {{ trans('company.header_company_address') }}
                    <i class="fa fa-sort" data-sort="filter-address"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-address', null, ['class' => 'form-control', 'tabindex' => 7]) }}
                </div>
            </th>
            <th class="col-ope-company">
                <div class="th-line-one">
                    {{ trans('company.header_company_operation_name') }}
                    <i class="fa fa-sort" data-sort="filter-company-operation"></i>
                </div>
                <div class="th-line-two">
                    {{ Form::text('filter-company-operation', null, ['class' => 'form-control', 'tabindex' => 8]) }}
                </div>
            </th>
            <th class="col-ope-person">
                {{ trans('company.header_company_ope_person.name_1') }}

                {{ Form::text('filter-company-ope-person-name-1', null, ['class' => 'form-control', 'tabindex' => 9]) }}
            </th>
            <th class="col-ope-email">
                {{ trans('company.header_company_ope_person.email_1') }}

                {{ Form::text('filter-company-ope-person-email-1', null, ['class' => 'form-control', 'tabindex' => 10]) }}
            </th>
            <th class="col-ope-phone">
                {{ trans('company.header_company_ope_person.phone_1') }}

                {{ Form::text('filter-company-ope-person-phone-1', null, ['class' => 'form-control', 'tabindex' => 11]) }}
            </th>
            <th class="col-ope-person">
                {{ trans('company.header_company_ope_person.name_2') }}

                {{ Form::text('filter-company-ope-person-name-2', null, ['class' => 'form-control', 'tabindex' => 12]) }}
            </th>
            <th class="col-ope-email">
                {{ trans('company.header_company_ope_person.email_2') }}

                {{ Form::text('filter-company-ope-person-email-2', null, ['class' => 'form-control', 'tabindex' => 13]) }}
            </th>
            <th class="col-ope-phone">
                {{ trans('company.header_company_ope_person.phone_2') }}

                {{ Form::text('filter-company-ope-person-phone-2', null, ['class' => 'form-control', 'tabindex' => 14]) }}
            </th>
            <th class="thead-text col-service-name">
                {{ trans('company.header_system_name') }}
            </th>
            <th class="thead-text col-license">
                {{ trans('company.header_license') }}
            </th>
            <th class="thead-text col-toltal-license">
                {{ trans('company.header_total_license') }}
            </th>
            <th class="col-action">
                {{ Form::button(trans('company.btn_filter'), [
                        'class' => 'btn btn-blue-dark btn-custom-sm',
                        'id' => 'btn-filter',
                        'data-url' => route('company.filter'),
                        'tabindex' => 15,
                    ])
                }}
            </th>
        </tr>
    </thead>
    @include('company.component.list.table-tbody-company')
</table>
{{-- <div class="table-content">
    @include('company.component.list.table-tbody-company')
</div> --}}
