@php $totalResult = count(collect($companies->items())->groupBy('service_id')); @endphp
<table class="table table-blue table-result"
    data-total="{{ trans('company.lbl_total_result', ['total' => $totalResult]) }}">
    <tbody>

        <!-- Init variable count and tracker for group -->
        @php $count = 1; $tracker = []; $groupCompanyId = []; @endphp

        <!-- Loop companies group by service -->
        @foreach ($companies as $index => $company)

            <!-- Count rowspan and tracker for group  -->
            @for ($i = $index + 1; $i < $companies->count(); $i++)

                <!-- Check company->serivce_id was tracked, if not count + 1 and mark company is tracked for group -->
                @if ($companies[$i]->service_id === $companies[$index]->service_id && !in_array($i, $tracker))
                    @php $count++; $tracker[] = $i; $groupCompanyId[] = $companies[$i]->id; @endphp
                @else

                    <!-- Break loop if company[i]->serivce_id != companies[index]->serivce_id -->
                    @break
                @endif
            @endfor

            <!-- Check companies[index] was tracked, if not add rowspan for column service -->
            @if (!in_array($index, $tracker))
                <tr>
                    <td rowspan="{{ $count }}" class="custom-checkbox checkbox-table col-checkbox">
                        {{ Form::checkbox('cb-get-id[]', $company->service_id, false, [
                                'id' => 'cb-get-id-' . $company->service_id,
                                'data-company-ids' => $company->id . ',' . implode(',', $groupCompanyId),
                            ])
                        }}
                        <label for="cb-get-id-{{ $company->service_id }}"></label>
                    </td>
                    <td rowspan="{{ $count }}" class="col-service-name">
                        <a href="javascript:void(0)"
                            class="open-popup-detail-service"
                            id="select-protector-btn-{{ $company->service_id }}"
                            data-url="{{ route('company.detail', ['id' => $company->service_id]) }}">{{ $company->service_name_jp }}
                        </a>
                    </td>
                    <td class="col-company-nation">
                        {{ $company->nation_jp }}
                    </td>
                    <td class="col-office-address">
                        {{ $company->head_office_address }}
                    </td>
                    <td  class="col-ope-company">
                        {{ $company->ope_company_name }}
                    </td>
                    <td class="col-ope-person">
                        {{ $company->ope_person_name_1 }}
                    </td>
                    <td class="col-ope-email">
                        {{ $company->ope_email_1 }}
                    </td>
                    <td class="col-ope-phone">
                        {{ $company->ope_phone_1 }}
                    </td>
                    <td class="col-ope-person">
                        {{ $company->ope_person_name_2 }}
                    </td>
                    <td class="col-ope-email">
                        {{ $company->ope_email_2 }}
                    </td>
                    <td class="col-ope-phone">
                        {{ $company->ope_phone_2 }}
                    </td>
                    <td class="col-company-name">
                        {{ $company->name_jp }}
                    </td>
                    <td class="col-license">{{ $company->license }}</td>
                    <td rowspan="{{ $count }}" class="col-toltal-license">{{ $company->total_license }}</td>
                    <td class="table-action col-action">
                        <a href="{{ route('company.show', $company->id) }}" class="btn btn-blue-dark btn-custom-sm btn-lock">
                            {{ trans('company.btn_detail') }}
                        </a>
                    </td>
                </tr>

            <!-- Check companies[index] was tracked -->
            @elseif (in_array($index, $tracker))
                <tr>
                    <td class="col-company-nation">
                        {{ $company->nation_jp }}
                    </td>
                    <td class="col-office-address">
                        {{ $company->head_office_address }}
                    </td>
                    <td  class="col-ope-company">
                        {{ $company->ope_company_name }}
                    </td>
                    <td class="col-ope-person">
                        {{ $company->ope_person_name_1 }}
                    </td>
                    <td class="col-ope-email">
                        {{ $company->ope_email_1 }}
                    </td>
                    <td class="col-ope-phone">
                        {{ $company->ope_phone_1 }}
                    </td>
                    <td class="col-ope-person">
                        {{ $company->ope_person_name_2 }}
                    </td>
                    <td class="col-ope-email">
                        {{ $company->ope_email_2 }}
                    </td>
                    <td class="col-ope-phone">
                        {{ $company->ope_phone_2 }}
                    </td>
                    <td class="col-company-name">
                        {{ $company->name_jp }}
                    </td>
                    <td class="col-license">{{ $company->license }}</td>
                    <td class="table-action col-action">
                        <a href="{{ route('company.show', $company->id) }}" class="btn btn-blue-dark btn-custom-sm btn-lock">
                            {{ trans('company.btn_detail') }}
                        </a>
                    </td>
                </tr>

                <!-- Check id companies[index] != id companies[index + 1] and reset variabel count and tracker -->
                @if ($index == $companies->count() - 1 || $company->service_id !== $companies[$index + 1]->service_id)
                    @php $count = 1; $tracker = []; $groupCompanyId = []; @endphp
                @endif
            @endif
        @endforeach
    </tbody>
</table>
