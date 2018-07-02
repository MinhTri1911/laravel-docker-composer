<?php

/**
 * Model ShipSPOT
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TShipSpot
 * 
 * @property int $id
 * @property int $ship_id
 * @property string $usage_month
 * @property string $type
 * @property string $currency
 * @property float $amount_charge
 * @property string $notice
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
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'ship_id' => 'int',
        'amount_charge' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'ship_id',
        'usage_month',
        'type',
        'currency',
        'amount_charge',
        'notice',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
