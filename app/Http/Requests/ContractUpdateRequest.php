<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractUpdateRequest extends FormRequest
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
            'serviceIdHidden'   => 'exists_service',
            'chargeRegister'    => 'money',
            'chargeCreate'      => 'money',
            'startDate'         => 'required|date|date_format:Y/m/d|after_or_equal:'.date('Y-m-d'),
            'endDate'           => 'required|date|date_format:Y/m/d|after_date_custom:startDate|before_or_equal:'.date('Y-m-t')
        ];
    }

    public function messages() {
        return [
            'serviceIdHidden.exists_service' => __('contract.error.service_not_exist'),
            'startDate.required'            => __('contract.error.E003', ['item' =>__('contract.lbl_start')]),
            'startDate.date'                => __('contract.error.E016', ['item' =>__('contract.lbl_start')]),
            'startDate.date_format'         => __('contract.error.E005', ['item' =>__('contract.lbl_start')]),
            'startDate.after_or_equal'      => __('contract.error.E020', ['item' =>__('contract.lbl_start'), 'value' => date('Y/m/d')]),
            'endDate.required'              => __('contract.error.E003', ['item' =>__('contract.lbl_end')]),
            'endDate.date'                  => __('contract.error.E016', ['item' =>__('contract.lbl_end')]),
            'endDate.date_format'           => __('contract.error.E005', ['item' =>__('contract.lbl_end')]),
            'endDate.after_date_custom'     => __('contract.error.E012'),
            'endDate.before_or_equal'       => __('contract.error.E007', ['item' => __('contract.lbl_end'), 'monthyear' => date('Y/m')]),
        ];
    }

}
