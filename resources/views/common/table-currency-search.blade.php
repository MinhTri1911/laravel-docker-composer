@foreach ($currency as $index => $currencyData)
    <tr>
        <td class="col-nation-id">{{ $currencyData->id }}</td>
        <td class="col-nation-name">{{ $currencyData->code }}</td>
        <td class="col-action">
            <div class="custom-radio">
                {{ Form::radio('choose-currency-id', $currencyData->id, false, [
                        'class' => 'hidden radio-nation',
                        'id' => 'choose-currency-id-' . $currencyData->id,
                        'data-currency-code' => $currencyData->code,
                        'checked' => $index == 0,
                    ])
                }}
                <label for="choose-currency-id-{{ $currencyData->id }}"></label>
            </div>
        </td>
    </tr>
@endforeach
