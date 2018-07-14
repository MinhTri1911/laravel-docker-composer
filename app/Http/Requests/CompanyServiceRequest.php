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
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator validator
     * @return void
     */
    public function withValidator($validator)
    {
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($this->get('company-id'));
        $checkExists = $this->_companyServiceBusiness->checkServiceId($this->get('service-id'), $currencyId);

        if (!$checkExists) {
            $validator->after(function ($validator) {
                $validator->errors()->add('service-id', trans('validation.exists', [
                        'attribute' => trans('company.lbl_service_name')
                    ])
                );
            });
        }
    }
}
