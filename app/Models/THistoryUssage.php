<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class THistoryUssage
 * 
 * @property int $id
 * @property int $ship_id
 * @property \Carbon\Carbon $month_usage
 * @property int $currency_id
 * @property float $total_amount_billing
 * @property float $total_money
 * @property string $remark
 * @property bool $billed_flag
 * @property bool $status
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class THistoryUssage extends Eloquent
{
    protected $table = 't_history_ussage';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'ship_id' => 'int',
        'currency_id' => 'int',
        'total_amount_billing' => 'float',
        'total_money' => 'float',
        'billed_flag' => 'bool',
        'status' => 'bool'
    ];

    protected $dates = [
        'month_usage'
    ];

    protected $fillable = [
        'ship_id',
        'month_usage',
        'currency_id',
        'total_amount_billing',
        'total_money',
        'remark',
        'billed_flag',
        'status',
        'created_by',
        'updated_by'
    ];
}
