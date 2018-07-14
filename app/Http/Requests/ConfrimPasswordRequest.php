<?php

/**
 * File confirm password request
 * Hanlde check validation request is coming
 *
 * @package App\Http\Controllers
 * @author Rikkei.trihnm
 * @date 2018/07/13
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfrimPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'require|min:6',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator validator
     * @return void
     */
    public function withValidator($validator)
    {
        // Get user info
        $user = \DB::table('t_user_login')
            ->where('id', auth()->id())
            ->first();

        // Verify password user to delete
        if (is_null($user) || !\Hash::check($this->get('password'), $user->password)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('password', trans('company.e022_password_not_match'));
            });
        }
    }
}
