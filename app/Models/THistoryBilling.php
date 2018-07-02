<?php

/**
 * Model HistoryBilling
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class THistoryBilling
 * 
 * @property int $id
 * @property int $company_id
 * @property \Carbon\Carbon $claim_date
 * @property int $billing_method_id
 * @property \Carbon\Carbon $payment_due_date
 * @property int $billing_day_no
 * @property \Carbon\Carbon $payment_actual_date
 * @property string $currency
 * @property float $total_amount_billing
 * @property float $total_monthly_charge
 * @property float $total_inital_charge
 * @property float $total_create_data_cost
 * @property float $total_spot_cost
 * @property float $total_discount
 * @property float $total_commission_other_charge
 * @property float $total_consumption_tax
 * @property string $notice
 * @property int $ope_company_id
 * @property string $pdf_original_link
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class THistoryBilling extends Eloquent
{
    protected $table = 't_history_billing';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'company_id' => 'int',
        'billing_method_id' => 'int',
        'billing_day_no' => 'int',
        'total_amount_billing' => 'float',
        'total_monthly_charge' => 'float',
        'total_inital_charge' => 'float',
        'total_create_data_cost' => 'float',
        'total_spot_cost' => 'float',
        'total_discount' => 'float',
        'total_commission_other_charge' => 'float',
        'total_consumption_tax' => 'float',
        'ope_company_id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'claim_date',
        'payment_due_date',
        'payment_actual_date'
    ];

    protected $fillable = [
        'company_id',
        'claim_date',
        'billing_method_id',
        'payment_due_date',
        'billing_day_no',
        'payment_actual_date',
        'currency',
        'total_amount_billing',
        'total_monthly_charge',
        'total_inital_charge',
        'total_create_data_cost',
        'total_spot_cost',
        'total_discount',
        'total_commission_other_charge',
        'total_consumption_tax',
        'notice',
        'ope_company_id',
        'pdf_original_link',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
