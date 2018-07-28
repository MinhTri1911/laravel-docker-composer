<?php
/**
 * CustomValidate.php
 * Handle check validate of rule
 *
 * @package CustomValidate
 * @author Rikkei.DungLV
 * @date 2018/07/11
 */

namespace App\Validators;

use DB;
use App\Common\Constant;

class CustomValidateSpot
{
    /**
     * Check valid value of charge of spot
     * 
     * @param array $attribute
     * @param int $value
     * @param array $parameters
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @return boolean
     */
    public function validateMoneySpot($attribute, $value, $parameters, $validator)
    {
        // Set label show message after validate
        $label = [
                'chargeRegister' => __('contract.lbl_spot_regist'),
                'chargeCreate' => __('contract.lbl_spot_data')
            ];

        if (!is_null($value)) {
            // Convert value to number, remove comma character
            $value = preg_replace('/(.00)|([^0-9]+)/', '', $value);
            // Charge spot must to is number
            if (!is_numeric($value)) {
                $validator->errors()->add($attribute, __('contract.error.spot_is_number', ['item' => $label[$attribute]]));
                return false;
            }
            // Charge spot must to greater or equal than 0
            if ($value < 0) {
                $validator->errors()->add($attribute, __('contract.error.spot_gt_zero', ['item' => $label[$attribute]]));
                return false;
            }
            // Length of charge must to less than 22
            if (strlen($value) > 22) {
                $validator->errors()->add($attribute, __('contract.error.spot_max_length', ['item' => $label[$attribute]]));
                return false;
            }
        }

        return true;
    }

    /**
     * Validate date of contract with end date is less than start date.
     * 
     * @param array $attribute
     * @param int $value [Value of end date]
     * @param array $parameters
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @return boolean
     */
    public function validateAfterDateCustom($attribute, $value, $parameters, $validator)
    {
        // If value is null then pass
        if (is_null($value)) {
            return true;
        }

        // Get data of request
        $dataValidator = $validator->getData();

        // When user input start date, check valid value
        if (isset($dataValidator[$parameters[0]]) && !is_null($dataValidator[$parameters[0]]) 
                && preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $value)) {
            // Convert value to Object Datetime
            $startDate = date_create($dataValidator[$parameters[0]]);
            $endDate = date_create($value);
            $dateDiff = date_diff($startDate, $endDate);
            // Check valid value date end and date start
            if($dateDiff->days == 0 || ($dateDiff->days > 0 && $dateDiff->invert > 0)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check exists service in table m_service
     * 
     * @param array $attribute
     * @param int $value [Value of end date]
     * @param array $parameters
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @return boolean [True if exists in database else not exists data]
     */
    public function validateExistsService($attribute, $value, $parameters, $validator)
    {
        if (!is_null($value) && is_numeric($value)) {
            $alreadyService = DB::table('m_service')
                ->where([
                    'm_service.id' => $value,
                    'm_service.del_flag' => Constant::DELETE_FLAG_FALSE,
                ])
                ->first();
            if (!is_null($alreadyService) && count($alreadyService) > 0) {
                return true;
            }

            return false;
        }

        return true;
    }
}
