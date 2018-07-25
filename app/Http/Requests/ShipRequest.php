<?php

/**
 * Validation ship service request
 * Handle check validation request is coming
 *
 * @package App\Http\Requests
 * @author Rikkei.QuyenL
 * @date 2018/07/23
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Ship\ShipInterface;

/**
 * Class ShipRequest
 */
class ShipRequest extends FormRequest
{
    /**
     * Ship interface
     *
     * @var $_shipInterface
     */
    protected $_shipInterface;

    /**
     * ShipRequest constructor.
     *
     * @param ShipInterface $shipInterface
     */
    public function __construct(ShipInterface $shipInterface) {
         parent::__construct();
        $this->_shipInterface = $shipInterface;
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
            'slb-company' => 'required',
            'txt-imo-number' => 'required|max:15',
            'txt-mmsi-number' => 'nullable|max:20',
            'nation-id' => 'required',
            'slb-classification' => 'required',
            'txt-register-number' => 'nullable|max:20',
            'slb-ship-type' => 'required',
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Custom messages
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
        // Call ship repository and get data
        $listCompany = $this->_shipInterface->getListCompany();
        $existCompany = $this->_shipInterface->checkExistCompany($this->get('slb-company'));

        $listNation = $this->_shipInterface->getListNation();
        $existNation = $this->_shipInterface->checkExistNation($this->get('nation-id'));

        $listClassification = $this->_shipInterface->getListClassification();
        $existClassification = $this->_shipInterface->checkExistClassification($this->get('slb-classification'));

        $listShipType = $this->_shipInterface->getListShipType();
        $existShipType = $this->_shipInterface->checkExistShipType($this->get('slb-ship-type'));

        // Check if list company is empty
        if (empty($listCompany) || ! $existCompany) {
            $validator->after(function ($validator) {
                $validator->errors()->add('slb-company', trans('error.e009_not_exists_master', [
                        'field' => trans('ship.lbl_title_company')
                    ])
                );
            });
        }
        // Check nation is empty
        if (empty($listNation) || ! $existNation) {
            $validator->after(function ($validator) {
                $validator->errors()->add('nation-id', trans('error.e009_not_exists_master', [
                        'field' => trans('ship.lbl_title_nation')
                    ])
                );
            });
        }
        // Check classification is empty
        if (empty($listClassification) || ! $existClassification) {
            $validator->after(function ($validator) {
                $validator->errors()->add('slb-classification', trans('error.e009_not_exists_master', [
                        'field' => trans('ship.lbl_title_classification')
                    ])
                );
            });
        }
        // Check classification is empty
        if (empty($listShipType) || ! $existShipType) {
            $validator->after(function ($validator) {
                $validator->errors()->add('slb-ship-type', trans('error.e009_not_exists_master', [
                        'field' => trans('ship.lbl_title_ship_type')
                    ])
                );
            });
        }
    }
}
