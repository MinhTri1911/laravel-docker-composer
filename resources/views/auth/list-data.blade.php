@if ($users->isEmpty())
    <tr>
        <td colspan="8" class="text-center">{{ __('common-message.warning.W003') }}</td>
    </tr>
@else
    @foreach ($users as $user)
        <tr data-id="{{ $user->id }}">
            <td class="text-center">
                {{ $user->id }}
            </td>
            <td class="">
                {{ $user->login_id }}
            </td>
            <td class="text-center">
                <div class="custom-checkbox">
                    {!!
                     Form::checkbox('auth-create-id-' . $user->id,
                        $user->auth_create,
                        $user->auth_create,
                        [
                            'id' => 'auth-create-id-' . $user->id,
                            'class' => 'hidden checkSingle',
                            'data-value' => $user->auth_create ? \Constant::ROLE_STATUS_TRUE : \Constant::ROLE_STATUS_FALSE,
                        ]
                    )
                     !!}
                    <label for="auth-create-id-{{ $user->id }}"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-checkbox">
                    {!!
                     Form::checkbox('auth-approve-id-' . $user->id,
                        $user->auth_approve,
                        $user->auth_approve,
                        [
                            'id' => 'auth-approve-id-' . $user->id,
                            'class' => 'hidden checkSingle',
                            'data-value' => $user->auth_approve ? \Constant::ROLE_STATUS_TRUE : \Constant::ROLE_STATUS_FALSE,
                        ]
                    )
                     !!}
                    <label for="auth-approve-id-{{ $user->id }}"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-checkbox">
                    {!!
                     Form::checkbox('auth-reference-id-' . $user->id,
                        $user->auth_reference,
                        $user->auth_reference,
                        [
                            'id' => 'auth-reference-id-' . $user->id,
                            'class' => 'hidden checkSingle',
                            'data-value' => $user->auth_reference ? \Constant::ROLE_STATUS_TRUE : \Constant::ROLE_STATUS_FALSE,
                        ]
                    )
                     !!}
                    <label for="auth-reference-id-{{ $user->id }}"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-checkbox">
                    {!!
                     Form::checkbox('auth-operation-id-' . $user->id,
                        $user->auth_operation,
                        $user->auth_operation,
                        [
                            'id' => 'auth-operation-id-' . $user->id,
                            'class' => 'hidden checkSingle',
                            'data-value' => $user->auth_operation ? \Constant::ROLE_STATUS_TRUE : \Constant::ROLE_STATUS_FALSE,
                        ]
                    )
                     !!}
                    <label for="auth-operation-id-{{ $user->id }}"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="custom-checkbox">
                    @php
                        $checkAll = ($user->auth_create && $user->auth_approve && $user->auth_reference && $user->auth_operation) ? true : false;
                    @endphp
                    {!!
                     Form::checkbox('auth-all-id-' . $user->id,
                        false,
                        $checkAll,
                        [
                            'id' => 'auth-all-id-' . $user->id,
                            'class' => 'hidden checkAll',
                        ]
                    )
                     !!}
                    <label for="auth-all-id-{{ $user->id }}"></label>
                </div>
            </td>
        </tr>
    @endforeach
@endif