<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Business\ContractBusiness;

class RestoreContractRequest extends FormRequest
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
    public function rules(ContractBusiness $contractBusiness)
    {
        $rulesDateContract = $contractBusiness->addValidateDateContract($this);
        return array_merge([
            'idService'         => 'required',
            'idShip'            => 'required',
            'serviceIdHidden'   => 'exists_service',
            'chargeRegister'    => 'money',
            'chargeCreate'      => 'money',
            'remark'            => 'nullable|max:255'
        ], $rulesDateContract);
    }

    /**
     * List message after validate request
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'idService.required'            => __('contract.error.E003', ['item' =>__('contract.lbl_service')]),
            'idShip.required'               => __('contract.error.E003', ['item' =>__('contract.lbl_ship')]),
            'serviceIdHidden.exists_service'=> __('contract.error.service_not_exist'),
            'startDate.required'            => __('contract.error.E003', ['item' =>__('contract.lbl_start')]),
            'startDate.date'                => __('contract.error.E016', ['item' =>__('contract.lbl_start')]),
            'startDate.date_format'         => __('contract.error.E005', ['item' =>__('contract.lbl_start')]),
            'startDate.after_or_equal'      => __('contract.error.E020', ['item' =>__('contract.lbl_start'), 'value' => ':date']),
            'startDate.before_or_equal'     => __('contract.error.E019', ['item' =>__('contract.lbl_start'), 'value' => ':date']),
            'endDate.required'              => __('contract.error.E003', ['item' =>__('contract.lbl_end')]),
            'endDate.date'                  => __('contract.error.E016', ['item' =>__('contract.lbl_end')]),
            'endDate.date_format'           => __('contract.error.E005', ['item' =>__('contract.lbl_end')]),
            'endDate.after_date_custom'     => __('contract.error.E012'),
            'endDate.after_or_equal'        => __('contract.error.E020', ['item' => __('contract.lbl_end'), 'value' => date('Y/m/d', strtotime('+1 day'))]),
            'remark.max'                    => __('contract.error.E004', ['item' => __('contract.lbl_remarks'), 'value' => 255])
        ];
    }
}
