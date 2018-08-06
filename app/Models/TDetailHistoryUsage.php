<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TDetailHistoryUsage
 * 
 * @property int $id
 * @property int $history_usage_id
 * @property int $charge_type_id
 * @property int $detail_charge_type_id
 * @property \Carbon\Carbon $month_usage
 * @property string $description
 * @property int $currency_id
 * @property float $money_billing
 * @property float $money
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class TDetailHistoryUsage extends Eloquent
{
    protected $table = 't_detail_history_usage';

    protected $casts = [
        'history_usage_id' => 'int',
        'charge_type_id' => 'int',
        'detail_charge_type_id' => 'int',
        'currency_id' => 'int',
        'money_billing' => 'float',
        'money' => 'float'
    ];

    protected $dates = [
        'month_usage'
    ];

    protected $fillable = [
        'history_usage_id',
        'charge_type_id',
        'detail_charge_type_id',
        'month_usage',
        'description',
        'currency_id',
        'money_billing',
        'money',
        'created_by',
        'updated_by'
    ];
}
