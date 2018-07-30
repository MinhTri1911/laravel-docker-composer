<?php

/**
 * File company request
 * Hanlde check validation request is coming
 *
 * @package App\Http\Requests
 * @author Rikkei.trihnm
 * @date 2018/07/30
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'slb-company-month-billing.*' => 'nullable|numeric|max:1,12',
            'txt-company-payment-deadline-no' => 'nullable|numeric|max:0,12',
            'txt-company-site' => 'nullable|digits_between:0,10',
            'txt-company-currency-code' => 'required|max:20',
            'slb-company-operation' => 'required',
            'txt-company-url' => 'nullable|max:255',
            'txt-ope-name-1' => 'required|max:100',
            'txt-ope-position-1' => 'max:100',
            'txt-ope-department-1' => 'max:100',
            'txt-ope-postal-code-1' => 'max:20',
            'txt-ope-address-1' => 'max:150',
            'txt-ope-phone-1' => 'max:20|regex:/[0-9]{11,20}/',
            'txt-ope-fax-1' => 'max:20',
            'txt-ope-email-1' => 'required|max:150',
            'txt-ope-name-2' => 'max:100',
            'txt-ope-position-2' => 'max:100',
            'txt-ope-department-2' => 'max:100',
            'txt-ope-postal-code-2' => 'max:20',
            'txt-ope-address-2' => 'max:150',
            'txt-ope-phone-2' => 'max:20|regex:/[0-9]{11,20}/',
            'txt-ope-fax-2' => 'max:20',
            'txt-ope-email-2' => 'max:150',
            'txt-ship-name' => 'required|max100',
            'txt-ship-imo-number' => 'required|max:15',
            'ship-nation-id' => 'required',
            'slb-ship-classification' => 'required',
            'slb-ship-type' => 'required',
        ];
    }

    public function messages()
    {
        # code...
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator validator
     * @return void
     */
    public function withValidator($validator)
    {

        //company-nation-id
        //company-currency-id
        //slb-company-operation
        //slb-company-billing-method
        //slb-company-operation
        //ship-nation-id
        //slb-ship-classification
        //slb-ship-type
    }
}
