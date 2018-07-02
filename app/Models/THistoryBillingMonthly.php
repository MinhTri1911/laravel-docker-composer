<?php

/**
 * Model HistoryBillingMonthly
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class THistoryBillingMonthly
 * 
 * @property int $id
 * @property int $contract_id
 * @property string $usage_month
 * @property int $history_billing_id
 * @property string $currency
 * @property float $total_month_billing
 * @property float $month_usage_charge
 * @property float $inital_charge
 * @property float $create_data_cost
 * @property float $spot_cost
 * @property float $discount
 * @property string $notice
 * @property bool $status
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class THistoryBillingMonthly extends Eloquent
{
    protected $table = 't_history_billing_monthly';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'contract_id' => 'int',
        'history_billing_id' => 'int',
        'total_month_billing' => 'float',
        'month_usage_charge' => 'float',
        'inital_charge' => 'float',
        'create_data_cost' => 'float',
        'spot_cost' => 'float',
        'discount' => 'float',
        'status' => 'bool',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'contract_id',
        'usage_month',
        'history_billing_id',
        'currency',
        'total_month_billing',
        'month_usage_charge',
        'inital_charge',
        'create_data_cost',
        'spot_cost',
        'discount',
        'notice',
        'status',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
