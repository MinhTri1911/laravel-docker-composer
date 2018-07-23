@foreach ($nations as $nation)
    <tr>
        <td class="col-nation-id">{{ $nation->id }}</td>
        <td class="col-nation-name">{{ $nation->name_jp }}</td>
        <td class="col-action">
            <div class="custom-radio">
                {{ Form::radio('choose-nation-id', $nation->id, false, [
                        'class' => 'hidden radio-nation',
                        'id' => 'choose-nation-id-' . $nation->id,
                        'data-nation-name' => $nation->name_jp,
                    ])
                }}
                <label for="choose-nation-id-{{ $nation->id }}"></label>
            </div>
        </td>
    </tr>
@endforeach
