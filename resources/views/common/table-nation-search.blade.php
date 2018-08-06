{{-- Check validation fail then setting checked old value --}}
@php
    $status = ($type == 'company') ? old('company-nation-id') : old('ship-nation-id');

    if ($type == 'ship' && !$status) {
        $status = old('nation-id');
    }
@endphp

@foreach ($nations as $index => $nation)
    <tr>
        <td class="col-nation-id">{{ $nation->id }}</td>
        <td class="col-nation-name">{{ $nation->name_jp }}</td>
        <td class="col-action">
            <div class="custom-radio">
                {{ Form::radio($type . '-choose-nation-id' , $nation->id, false, [
                        'class' => 'hidden radio-nation',
                        'id' => 'choose-nation-id-' . $nation->id . '-' . $type,
                        'data-nation-name' => $nation->name_jp,
                        'checked' => (($index == 0 && !$status) || $status == $nation->id),
                    ])
                }}
                <label for="choose-nation-id-{{ $nation->id }}-{{ $type }}"></label>
            </div>
        </td>
    </tr>
@endforeach
