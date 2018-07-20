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
use App\Repositories\MSpot\MSpotInterface;
use App\Repositories\MCurrency\MCurrencyInterface;
use App\Repositories\Company\CompanyInterface;
use App\Common\Common;

class SpotRequest extends FormRequest {

    private $_mSpotInterface;
    private $_mCurrencyInterface;
    private $_companyInterface;
    
    public function __construct(MSpotInterface $mSpotInterface, MCurrencyInterface $mCurrencyInterface, CompanyInterface $companyInterface) {
        $this->_mSpotInterface = $mSpotInterface;
        $this->_mCurrencyInterface = $mCurrencyInterface;
        $this->_companyInterface = $companyInterface;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $now = date('Y/m/d');

        $rules = [
            'spotId' => 'required',
            'dateStart' => 'required|date_format:Y/m/d|after_or_equal:' . $now,
            'amountCharge' => 'required|min:0',
        ];

        return $rules;
    }

    public function messages() {
        return [
            'dateStart.required' => __('spot.error.E003', ['item' => __('spot.lbl_spot_month_usage')]),
            'dateStart.date_format' => __('spot.error.E005', ['item' => __('spot.lbl_spot_month_usage')]),
            'dateStart.after_or_equal' => __('spot.error.E020', ['item' => __('spot.lbl_spot_month_usage'), 'value' => date('Y/m/d')]),
            'amountCharge.min' => __('spot.error.E020', ['item' => __('spot.lbl_spot_amount_charge'), 'value' => '0']),
            'amountCharge.required' => __('spot.error.E003', ['item' => __('spot.lbl_spot_amount_charge')]),
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator validator
     * @return void
     */
    public function withValidator($validator) {

        // Validate exit spot
        $idSpot = $this->get('spotId');

        if (!$this->_mSpotInterface->checkExits($idSpot)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('spotId', __('spot.spot_not_exits', ['value' => __('spot.lbl_spot_name')]));
            });
        }

        // Validate maxlength amountCharge
        $amountCharge = $this->get('amountCharge');

        if (strlen($amountCharge) > 22) {
            $validator->after(function ($validator) {
                $validator->errors()->add('amountCharge', __('spot.error.E004', ['item' => __('spot.lbl_spot_amount_charge'), 'value' => '22']));
            });
        }

        $remark = $this->get('remark');

        if (strlen($remark) > 255) {
            $validator->after(function ($validator) {
                $validator->errors()->add('remark', __('spot.error.E004', ['item' => __('spot.lbl_spot_remark'), 'value' => '255']));
            });
        }

        $currencyId = $this->get('currencyId');

        if (!$this->_mCurrencyInterface->checkExits($currencyId) || !$this->_companyInterface->checkExits($currencyId)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('spotId', __('spot.spot_not_exits', ['value' => __('spot.lbl_spot_amount_charge')]));
            });
        }
        
        $amountCharge = Common::foramtNumber($this->get('amountCharge'));
        
         // Check format number
        if (preg_match('/^[0-9]+$/', $amountCharge) == 0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('amountCharge', __('spot.error.E008', ['value' => __('spot.lbl_spot_amount_charge')]));
            });
        }
    }
}
