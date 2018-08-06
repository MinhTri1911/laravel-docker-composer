<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TShipSpot
 * 
 * @property int $id
 * @property int $ship_id
 * @property int $contract_id
 * @property \Carbon\Carbon $month_usage
 * @property int $spot_id
 * @property int $currency_id
 * @property float $amount_charge
 * @property string $remark
 * @property int $approved_flag
 * @property string $reason_reject
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class TShipSpot extends Eloquent
{
    protected $table = 't_ship_spot';

    protected $casts = [
        'ship_id' => 'int',
        'contract_id' => 'int',
        'spot_id' => 'int',
        'currency_id' => 'int',
        'amount_charge' => 'float',
        'approved_flag' => 'int',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'month_usage'
    ];

    protected $fillable = [
        'ship_id',
        'contract_id',
        'month_usage',
        'spot_id',
        'currency_id',
        'amount_charge',
        'remark',
        'approved_flag',
        'reason_reject',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
