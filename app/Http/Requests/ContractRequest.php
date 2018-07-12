<?php

/**
 * File company service request
 * Hanlde check validation request is coming
 *
 * @package App\Http\Controllers
 * @author Rikkei.trihnm
 * @date 2018/07/11
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Service\ServiceInterface;

class ContractRequest extends FormRequest 
{
    private $_serviceInterface;

    public function __construct(ServiceInterface $serviceInterface) 
    {
        $this->_serviceInterface = $serviceInterface;
    }

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
        $rules = [
            'idService' => 'required',
            'dateStart' => 'required|date_format:Y/m/d|after_or_equal:now',
            'dateEnd' => 'required|date_format:Y/m/d|after:dateStart',
            'chargeRegister' => 'nullable|numeric|min:0',
            'chargeCreate' => 'nullable|numeric|min:0',
        ];

        return $rules;
    }

    public function messages() 
    {
        return [
            'idService.required' => __('contract.error.E003', ['item' => __('contract.lbl_service')]),
            'dateStart.required' => __('contract.error.E003', ['item' => __('contract.lbl_start')]),
            'dateStart.date_format' => __('contract.error.E005', ['item' => __('contract.lbl_start')]),
            'dateStart.after_or_equal' => __('contract.error.E020', ['item' => __('contract.lbl_start'), 'value' => date('Y/m/d')]),
            'dateEnd.required' => __('contract.error.E003', ['item' => __('contract.lbl_end')]),
            'dateEnd.date_format' => __('contract.error.E005', ['item' => __('contract.lbl_end')]),
            'dateEnd.after' => __('contract.error.E006', ['startDate' => __('contract.lbl_start'), 'startEnd' => __('contract.lbl_end')]),
            'chargeRegister.min' => __('contract.error.E020', ['item' => __('contract.lbl_spot_regist'), 'value' => '0']),
            'chargeRegister.numeric' => __('contract.error.E008', ['value' => __('contract.lbl_spot_regist')]),
            'chargeCreate.min' => __('contract.error.E020', ['item' => __('contract.lbl_spot_data'), 'value' => '0']),
            'chargeCreate.numeric' => __('contract.error.E008', ['value' => __('contract.lbl_spot_data')]),
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
        // Validate maxlenght
        $chargeRegister = $this->get('chargeRegister');
        $chargeCreate = $this->get('chargeCreate');
        $remark = $this->get('remark');

        if (strlen($chargeRegister) > 22) {
            $validator->after(function ($validator) {
                $validator->errors()->add('chargeRegister', __('contract.error.E004', ['item' => __('contract.lbl_spot_regist'), 'value' => '22']));
            });
        }

        if (strlen($chargeCreate) > 22) {
            $validator->after(function ($validator) {
                $validator->errors()->add('chargeCreate', __('contract.error.E004', ['item' => __('contract.lbl_spot_data'), 'value' => '22']));
            });
        }

        if (strlen($remark) > 255) {
            $validator->after(function ($validator) {
                $validator->errors()->add('remark', __('contract.error.E004', ['item' => __('contract.lbl_remarks'), 'value' => '255']));
            });
        }

        // Check exits service by idService
        $idService = $this->get('serviceIdHidden');
        
        if (!$this->_serviceInterface->checkExits($idService)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('serviceIdHidden', __('contract.error.service_not_exist'));
            });
        }
    }
}
