<?php

/**
 * File ship contract request
 * Hanlde check validation request is coming
 *
 * @package App\Http\Controllers
 * @author Rikkei.trihnm
 * @date 2018/07/24
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Business\SpotBusiness;
use App\Business\SearchServiceBusiness;
use App\Business\CompanyBusiness;
use App\Business\NationBusiness;
use App\Business\ShipContractBusiness;

class ShipContractRequest extends FormRequest
{
    private $_serviceBusiness;
    private $_spotBusiness;

    public function __construct(SpotBusiness $spotBusiness, SearchServiceBusiness $service)
    {
        $this->_spotBusiness = $spotBusiness;
        $this->_serviceBusiness = $service;
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
            'txt-ship-name' => 'required|max:100',
            'txt-imo-number' => 'required|max:15',
            'txt-mmsi-number' => 'nullable|max:20',
            'nation-id' => 'required|digits_between:1,20',
            'slb-classification' => 'required|digits_between:1,20',
            'txt-register-number' => 'nullable|max:20',
            'slb-ship-type' => 'required|digits_between:1,20',
            'txt-ship-length' => 'nullable|digits_between:0,10',
            'txt-ship-width' => 'nullable|digits_between:0,10',
            'txt-water-draft' => 'nullable|digits_between:0,10',
            'txt-total-weight-ton' => 'nullable|digits_between:0,10',
            'txt-weight-ton' => 'nullable|digits_between:0,10',
            'txt-member-number' => 'nullable|integer|digits_between:0,5',
            'txt-remark' => 'nullable|max:255',
            'txt-url-1' => 'nullable|max:150|url',
            'txt-url-2' => 'nullable|max:150|url',
            'txt-url-3' => 'nullable|max:150|url'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nation-id.required' => trans('error.e003_required', ['field' => trans('ship.lbl_title_nation')]),
            'nation-id.digits_between' => trans('validation.digits_between', ['attribute' => trans('ship.lbl_title_nation')]),
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
        // Set count for spot
        $countSpot = 0;

        $services = $this->get('service');
        $getServiceIds = [];

        // Set check valid is true
        $isValidServiceIds = true;
        $isValidSpotIds = true;

        // Check exists services
        if ($services && is_array($services)) {
            $getServiceIds = array_merge(array_column($services, 'id'), $getServiceIds);

            $isValidServiceIds = $this->_serviceBusiness->checkServiceExistsWithCurrency($this->get('company-id'), $getServiceIds);
        }

        $spots = $this->get('spot');
        $getSpotIds = [];

        // Check exists spots
        if ($spots && is_array($spots)) {
            foreach ($spots as $spot) {
                $getSpotIds = array_merge(array_column($spot,'id'), $getSpotIds);
                $countSpot++;
            }

            $isValidSpotIds = $this->_spotBusiness->checkExistsSpotWithCurrency($this->get('company-id'), $getSpotIds);
        }

        // Check service id exists master and equal currency id with company
        if (!$isValidServiceIds) {
            $message = trans('error.e009_not_exists_master', [
                'field' => trans('company.lbl_service_name'),
            ]);
            $this->_addValidatorMessage($validator, 'service-id', $message);
        }

        // Check service id exists master and equal currency id with company and check spot is not match with service
        if (!$isValidSpotIds || (count($services) != $countSpot)) {
            $message = trans('error.e009_not_exists_master', [
                'field' => trans('ship.spot'),
            ]);
            $this->_addValidatorMessage($validator, 'spot-id', $message);
        }

        // Check nation id exists
        $nationBusiness = app(NationBusiness::class);
        $nation = $nationBusiness->checkExistsNationId($this->get('nation-id'));

        if (!$nation) {
            $message =  trans('error.e009_not_exists_master', [
                'field' => trans('ship.lbl_title_nation'),
            ]);
            $this->_addValidatorMessage($validator, 'nation-id', $message);
        }

        // Check company id exists
        $companyBusiness = app(CompanyBusiness::class);
        $company = $companyBusiness->checkExistsCompanyId($this->get('company-id'));

        if (!$company) {
            $message =  trans('error.e009_not_exists_master', [
                'field' => trans('ship.lbl_title_company'),
            ]);
            $this->_addValidatorMessage($validator, 'nation-id', $message);
        }

        // Check ship type exists
        $shipContractBusiness = app(ShipContractBusiness::class);
        $shipType = $shipContractBusiness->checkShipTypeExists($this->get('slb-ship-type'));

        if (!$shipType) {
            $message =  trans('error.e009_not_exists_master', [
                'field' => trans('ship.lbl_title_ship_type'),
            ]);
            $this->_addValidatorMessage($validator, 'slb-ship-type', $message);
        }

        // Check ship classification exists
        $shipClassification = $shipContractBusiness->checkShipClassificationExists($this->get('slb-classification'));

        if (!$shipClassification) {
            $message =  trans('error.e009_not_exists_master', [
                'field' => trans('ship.lbl_title_classification'),
            ]);
            $this->_addValidatorMessage($validator, 'slb-classification', $message);
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
