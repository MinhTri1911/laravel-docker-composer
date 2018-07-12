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
use App\Business\CompanyBusiness;
use App\Business\BillingMethodBusiness;

class BillingMethodRequest extends FormRequest
{
    private $_billingMethodBusiness;
    private $_companyBusiness;

    public function __construct(BillingMethodBusiness $billingMethod, CompanyBusiness $company)
    {
        $this->_billingMethodBusiness = $billingMethod;
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
        return [
            //
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
        // Check the billing method id is exists in database
        $validationExists = $this->_billingMethodBusiness->checkBillingMethodExists($this->get('billing-method-id'));

        // Get currency id of company
        $currencyId = $this->_companyBusiness->getCompanyCurrencyId($this->get('company-id'));

        // Check currency id of billing method is match with currency id of company
        $validationMatch = $this->_billingMethodBusiness->compareCurrencyId($this->get('billing-method-id'), $currencyId);

        // Return error if validation fail
        if (!$validationExists || !$validationMatch) {
            $validator->after(function ($validator) {
                $validator->errors()->add('billing-method-id', trans('error.e009_not_exists_master', [
                        'field' => trans('company.lbl_billing_method_name')
                    ])
                );
            });
        }
    }
}
