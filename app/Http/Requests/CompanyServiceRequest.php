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
use App\Business\CompanyServiceBusiness;
use App\Business\CompanyBusiness;

class CompanyServiceRequest extends FormRequest
{
    private $_companyServiceBusiness;
    private $_companyBusiness;

    public function __construct(CompanyServiceBusiness $companyService, CompanyBusiness $company)
    {
        $this->_companyServiceBusiness = $companyService;
        $this->_companyBusiness = $company;
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
        $now = date('Y/m/d');

        return [
            'service-id' => 'required|numeric',
            'start-date' => 'required|date_format:Y/m/d|after_or_equal:' . $now,
            'end-date' => 'required|date_format:Y/m/d|after:start-date',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $serviceId = trans('company.lbl_service_name');
        $startDate =  trans('company.lbl_contract_start_date');
        $endDate = trans('company.lbl_contract_end_date');

        return [
            'service-id.required' => trans('error.e003_required', ['field' => $serviceId]),
            'service-id.numeric' => trans('error.e008_numeric', ['field' => $serviceId]),
            'start-date.required' => trans('error.e003_required', ['field' => $startDate]),
            'start-date.date_format' => trans('error.e005_format_date', ['field' => $startDate, 'format' => 'Y/m/d']),
            'start-date.after_or_equal' => trans('error.e020_greater_than_or_equal', ['field' => $startDate]),
            'end-date.required' => trans('error.e003_required', ['field' => $endDate]),
            'end-date.date_format' => trans('error.e005_format_date', ['field' => $endDate, 'format' => 'Y/m/d']),
            'end-date.after' => trans('error.e012_start_date_less_than_end_date'),
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
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($this->get('company-id'));
        $checkExists = $this->_companyServiceBusiness->checkServiceId($this->get('service-id'), $currencyId);

        // Check service id exists master and equal currency id with company
        if (!$checkExists) {
            $validator->after(function ($validator) {
                $validator->errors()->add('service-id', trans('error.e009_not_exists_master', [
                        'field' => trans('company.lbl_service_name')
                    ])
                );
            });
        }
    }
}
