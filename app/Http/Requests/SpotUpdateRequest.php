<?php

/**
 * Update spot request
 * Handle check validation request is coming
 *
 * @package App\Http\Controllers
 * @author Rikkei.QuyenL
 * @date 2018/08/01
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\MSpot\MSpotInterface;
use App\Repositories\MCurrency\MCurrencyInterface;
use App\Repositories\Company\CompanyInterface;
use App\Repositories\TShipSpot\TShipSpotInterface;
use App\Common\Common;

class SpotUpdateRequest extends FormRequest {
    /**
     * MSpotInterface
     *
     * @var $_mSpotInterface
     */
    private $_mSpotInterface;

    /**
     * MCurrencyInterface
     *
     * @var $_mCurrencyInterface
     */
    private $_mCurrencyInterface;

    /**
     * CompanyInterface
     *
     * @var $_companyInterface
     */
    private $_companyInterface;

    /**
     * TShipSpotInterface
     *
     * @var $_tShipSpotInterface
     */
    private $_tShipSpotInterface;

    /**
     * SpotUpdateRequest constructor.
     *
     * @param MSpotInterface $mSpotInterface
     * @param MCurrencyInterface $mCurrencyInterface
     * @param CompanyInterface $companyInterface
     * @param TShipSpotInterface $shipSpot
     */
    public function __construct(MSpotInterface $mSpotInterface,
                                MCurrencyInterface $mCurrencyInterface,
                                CompanyInterface $companyInterface,
                                TShipSpotInterface $shipSpot
    ) {
        parent::__construct();
        $this->_mSpotInterface = $mSpotInterface;
        $this->_mCurrencyInterface = $mCurrencyInterface;
        $this->_companyInterface = $companyInterface;
        $this->_tShipSpotInterface = $shipSpot;
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
        $rules = [
            'spotId' => 'required',
            'dateStart' => 'required|date_format:Y/m/d',
            'amountCharge' => 'required|min:0',
        ];

        return $rules;
    }

    public function messages() {
        return [
            'dateStart.required' => __('spot.error.E003', ['item' => __('spot.lbl_spot_month_usage')]),
            'dateStart.date_format' => __('spot.error.E005', ['item' => __('spot.lbl_spot_month_usage')]),
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
        // Get ship spot data
        $shipSpot = $this->_tShipSpotInterface->getEditShipSpotData($this->get('shipSpotId'));
        $endMonthUsage = date("Y/m", strtotime($shipSpot->month_usage));

        // Validate pass month usage date
        if ($this->get('dateStart') < $endMonthUsage) {
            $validator->after(function ($validator) {
                $validator->errors()->add('dateStart', __('spot.error.E025', ['item' => __('spot.lbl_spot_month_usage')]));
            });
        }

        // Validate exist spot
        if (!$this->_mSpotInterface->checkExits($this->get('spotId'))) {
            $validator->after(function ($validator) {
                $validator->errors()->add('spotId', __('spot.spot_not_exits', ['value' => __('spot.lbl_spot_name')]));
            });
        }

        // Validate max length amountCharge
        if (strlen($this->get('amountCharge')) > 22) {
            $validator->after(function ($validator) {
                $validator->errors()->add('amountCharge', __('spot.error.E004', ['item' => __('spot.lbl_spot_amount_charge'), 'value' => '22']));
            });
        }

        // Validate max length remark
        if (strlen($this->get('remark')) > 255) {
            $validator->after(function ($validator) {
                $validator->errors()->add('remark', __('spot.error.E004', ['item' => __('spot.lbl_spot_remark'), 'value' => '255']));
            });
        }

        // Validate currency Id
        $currencyId = $this->get('currencyId');
        if (!$this->_mCurrencyInterface->checkExits($currencyId) || !$this->_companyInterface->checkExits($currencyId)) {
            $validator->after(function ($validator) {
                $validator->errors()->add('spotId', __('spot.spot_not_exits', ['value' => __('spot.lbl_spot_amount_charge')]));
            });
        }

        // Check format number
        $amountCharge = Common::formatNumber($this->get('amountCharge'));
        if (preg_match('/^[0-9]+$/', $amountCharge) == 0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('amountCharge', __('spot.error.E008', ['value' => __('spot.lbl_spot_amount_charge')]));
            });
        }
    }
}
