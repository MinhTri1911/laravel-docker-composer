<?php

/**
 * File company request
 * Hanlde check validation request is coming
 *
 * @package App\Http\Requests
 * @author Rikkei.trihnm
 * @date 2018/08/03
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'txt-company-name-jp' => 'required|max:100',
            'txt-company-name-en' => 'required|max:100',
            'company-nation-id' => 'required',
            'txt-company-postal-code' => 'max:20',
            'txt-company-address' => 'max:150',
            'txt-company-represent-person' => 'required|max:100',
            'txt-company-fund' => 'nullable|digits_between:1,22',
            'company-currency-id' => 'required',
            'txt-company-employee-number' => 'nullable|digits_between:1,5',
            'txt-company-year-research' => 'nullable|digits_between:1,4',
            'slb-company-billing-method' => 'required',
            'slb-company-month-billing.*' => 'nullable|integer|numeric|min:1|max:12',
            'txt-company-payment-deadline-no' => 'required|numeric|integer|min:0|max:12',
            'txt-company-site' => 'nullable|digits_between:0,10',
            'txt-company-currency-code' => 'required|max:20',
            'slb-company-operation' => 'required',
            'txt-company-url' => 'nullable|max:255|url',
            'txt-ope-name-1' => 'required|max:100',
            'txt-ope-position-1' => 'max:100',
            'txt-ope-department-1' => 'max:100',
            'txt-ope-postal-code-1' => 'max:20',
            'txt-ope-address-1' => 'max:150',
            'txt-ope-phone-1' => 'nullable|max:20|regex:/^[0-9]{10,}$/',
            'txt-ope-fax-1' => 'max:20',
            'txt-ope-email-1' => 'required|max:150|email',
            'txt-ope-name-2' => 'max:100',
            'txt-ope-position-2' => 'max:100',
            'txt-ope-department-2' => 'max:100',
            'txt-ope-postal-code-2' => 'max:20',
            'txt-ope-address-2' => 'max:150',
            'txt-ope-phone-2' => 'nullable|max:20|regex:/^[0-9]{10,}$/',
            'txt-ope-fax-2' => 'max:20',
            'txt-ope-email-2' => 'nullable|max:150|email',
        ];
    }

    public function messages()
    {
        $messages = [];

        if (empty($this->request->get('slb-company-month-billing'))) {
            return $messages;
        }

        foreach($this->request->get('slb-company-month-billing') as $key => $val) {
            $messages['slb-company-month-billing.' . $key . '.numeric'] = trans('validation.numeric', [
                'attribute' => trans('company.lbl_title_company_month_billing')
            ]);
            $messages['slb-company-month-billing.' . $key . '.max'] = trans('validation.max.numeric', [
                'attribute' => trans('company.lbl_title_company_month_billing'),
                'max' => 12,
            ]);
            $messages['slb-company-month-billing.' . $key . '.min'] = trans('validation.min.numeric', [
                'attribute' => trans('company.lbl_title_company_month_billing'),
                'max' => 1,
            ]);

            $messages['slb-company-month-billing.' . $key . '.integer'] = trans('validation.integer', [
                'attribute' => trans('company.lbl_title_company_month_billing'),
            ]);
        }

        return $messages;
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator validator
     * @return void
     */
    public function withValidator($validator)
    {
        $nationRepository = app(\App\Repositories\Nation\NationInterface::class);
        $checkNationExists = $nationRepository->where('id', $this->get('company-nation-id'))->exists();

        if (!$checkNationExists) {
            $this->_addValidatorMessage($validator, 'company-nation-id', trans('common-message.error.E009', [
                    'value' => trans('company.lbl_title_company_nation'),
                ])
            );
        }

        $currencyRepository = app(\App\Repositories\MCurrency\MCurrencyInterface::class);
        $checkCurrencyExists = $currencyRepository->where('id', $this->get('company-currency-id'))->exists();

        if (!$checkCurrencyExists) {
            $this->_addValidatorMessage($validator, 'company-currency-id', trans('common-message.error.E009', [
                    'value' => trans('company.lbl_title_company_currency'),
                ])
            );
        }

        $opeCompanyRepository = app(\App\Repositories\CompanyOperation\CompanyOpeInterface::class);
        $checkOpeCompanyExists = $opeCompanyRepository->where('id', $this->get('slb-company-operation'))->exists();

        if (!$checkOpeCompanyExists) {
            $this->_addValidatorMessage($validator, 'slb-company-operation', trans('common-message.error.E009', [
                    'value' => trans('company.lbl_title_company_operation'),
                ])
            );
        }

        $billingMethodRepository = app(\App\Repositories\BillingMethod\BillingMethodInterface::class);
        $currency = $this->get('company-currency-id');
        $checkBillingExists = $billingMethodRepository
            ->join('m_currency', function ($join) use ($currency) {
                $join->on('m_currency.id', 'm_billing_method.currency_id');
                $join->where('m_currency.id', $currency);
            })
            ->where('m_billing_method.id', $this->get('slb-company-billing-method'))
            ->exists();

        if (!$checkBillingExists) {
            $this->_addValidatorMessage($validator, 'slb-company-billing-method', trans('common-message.error.E009', [
                    'value' => trans('company.lbl_title_company_billing_method'),
                ])
            );
        }
    }

    /**
     * Function add message when validate fail
     *
     * @param \Illuminate\Validation\Validator $validator
     * @param string $name
     * @param string $message
     * @return void
     */
    private function _addValidatorMessage($validator, $name, $message)
    {
        $validator->after(function ($validator) use ($name, $message) {
            $validator->errors()->add($name, $message);
        });
    }
}
