<table class="table table-blue table-result">
    <tbody>
        @php $count = 1; $tracker = [];@endphp

        @foreach ($companies as $index => $company)
            @for($i = $index + 1; $i < $companies->count(); $i++)
                @if ($companies[$i]->id === $companies[$index]->id && !in_array($i, $tracker))
                    @php $count++; $tracker[] = $i; @endphp
                @else
                    @break
                @endif
            @endfor
            <!--begin grouping by company row 1-->
            @if (!in_array($index, $tracker))
                <tr>
                    <td rowspan="{{ $count }}" class="custom-checkbox checkbox-table col-checkbox">
                        {{ Form::checkbox('cb-company[]', 1, false, ['id' => 'cb-company-1']) }}
                        <label for="cb-company-1"></label>
                    </td>
                    <td  rowspan="{{ $count }}" class="col-company-name">
                        <a href="javascript:void(0)"
                            id="select-protector-btn"
                            class="open-popup-detail-company"
                            data-url="{{ route('company.detail') }}">
                                {{ $company->name_jp }}
                        </a>
                    </td>
                    <td  rowspan="{{ $count }}" class="col-company-nation">
                        {{ $company->nation_jp }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-office-address">
                        {{ $company->head_office_address }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-company">
                        {{ $company->ope_company_name }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-person">
                        {{ $company->ope_person_name_1 }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-email">
                        {{ $company->ope_email_1 }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-phone">
                        {{ $company->ope_phone_1 }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-person">
                        {{ $company->ope_person_name_2 }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-email">
                        {{ $company->ope_email_2 }}
                    </td>
                    <td  rowspan="{{ $count }}" class="col-ope-phone">
                        {{ $company->ope_phone_2 }}
                    </td>
                    <td class="col-service-name">{{ $company->service_name_jp }}</td>
                    <td class="col-license">{{ $company->license }}</td>
                    <td rowspan="{{ $count }}" class="col-toltal-license">35</td>
                    <td rowspan="{{ $count }}" class="table-action col-action">
                        <a href="{{ route('company.show', $company->id) }}" class="btn btn-blue-dark btn-custom-sm btn-lock">
                            {{ trans('company.btn_detail') }}
                        </a>
                    </td>
                </tr>
            @elseif (in_array($index, $tracker))
                <tr>
                    <td class="col-service-name">{{ $company->service_name_jp }}</td>
                    <td class="col-license">{{ $company->license }}</td>
                </tr>
                @if ($index == $companies->count() - 1 || $company->id !== $companies[$index + 1]->id)
                    @php $count = 1; $tracker = []; @endphp
                @endif
            @endif
        @endforeach
    </tbody>
</table>
