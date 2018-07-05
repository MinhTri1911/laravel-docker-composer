<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 04 Jul 2018 03:46:32 +0000.
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
 * @property int $payment_deadline_no
 * @property int $billing_day_no
 * @property \Carbon\Carbon $payment_actual_date
 * @property int $currency_id
 * @property float $total_amount_billing
 * @property float $total_money
 * @property int $ope_company_id
 * @property string $remark
 * @property string $pdf_original_link
 * @property int $approved_flag
 * @property string $reason_reject
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

    protected $casts = [
        'company_id' => 'int',
        'billing_method_id' => 'int',
        'payment_deadline_no' => 'int',
        'billing_day_no' => 'int',
        'currency_id' => 'int',
        'total_amount_billing' => 'float',
        'total_money' => 'float',
        'ope_company_id' => 'int',
        'approved_flag' => 'int'
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
        'payment_deadline_no',
        'billing_day_no',
        'payment_actual_date',
        'currency_id',
        'total_amount_billing',
        'total_money',
        'ope_company_id',
        'remark',
        'pdf_original_link',
        'approved_flag',
        'reason_reject',
        'created_by',
        'updated_by'
    ];
}
