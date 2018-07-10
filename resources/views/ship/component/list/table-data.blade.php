@php $totalResult = count(collect($ships->items())->groupBy('id')); @endphp
<table class="table table-blue table-result" data-total="{{ trans('ship.lbl_total_result', ['total' => $totalResult]) }}">
    <tbody class="tbody-scroll-1">
    @php
        // Row span number
        $number = 1;
        // Initial tracker empty array
        $tracker = [];

        // Contract btn class
        $contractClass = [
            0 => 'btn-green-dark',
            1 => 'btn-orange',
            2 => 'btn-red-dark',
            3 => 'btn-gray-dark',
        ]
    @endphp

    {{-- loop list ship data --}}
    @foreach ($ships as $key => $ship)
        @for($i = $key + 1; $i < $ships->count(); $i++)
            @if ($ships[$i]->id === $ships[$key]->id && !in_array($i, $tracker))
                @php $number++; $tracker[] = $i; @endphp
            @else
                @break
            @endif
        @endfor

        @if (!in_array($key, $tracker))
            <tr>
                <td class="col-ship-name" rowspan="{{ $number }}">
                    {{ $ship->name }}
                </td>
                <td class="col-company-name" rowspan="{{ $number }}">
                    {{ $ship->company_name_jp }}
                </td>
                <td class="col-classification" rowspan="{{ $number }}">
                    {{ $ship->ship_classification_name_jp }}
                </td>
                <td class="col-ship-type" rowspan="{{ $number }}">
                    {{ $ship->type }}
                </td>
                <td class="col-imo-number" rowspan="{{ $number }}">
                    {{ $ship->imo_number }}
                </td>
                <td class="col-ship-nation" rowspan="{{ $number }}">
                    {{ $ship->nation_name_jp }}
                </td>
                <td class="col-service">
                    {{ $ship->service_name_jp }}
                </td>
                <td class="col-action contract-status">
                    @if ($ship->status !== null)
                        <button class="btn btn-custom-sm {{ $contractClass[$ship->status] }}" type="button">{{ $contractStatus[$ship->status] }}</button>
                    @endif
                </td>
                <td class="col-action" rowspan="{{ $number }}">
                    <a href="{{ route('ship.contract.detail', ['id' => $ship->id]) }}" class="btn btn-blue-dark btn-custom-sm">
                        {{ trans('ship.btn_detail') }}
                    </a>
                </td>
            </tr>
        @elseif (in_array($key, $tracker))
            <tr>
                <td class="col-service">
                    {{ $ship->service_name_jp }}
                </td>
                @if ($ship->status !== null)
                    <td class="col-action contract-status">
                        <button class="btn btn-custom-sm {{ $contractClass[$ship->status] }}" type="button">{{ $contractStatus[$ship->status] }}</button>
                    </td>
                @endif
            </tr>
            @if ($key == $ships->count() - 1 || $ship->id !== $ships[$key + 1]->id)
                @php $number = 1; $tracker = []; @endphp
            @endif
        @endif
    @endforeach
    </tbody>
</table>