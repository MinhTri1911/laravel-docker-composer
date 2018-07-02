<?php

/**
 * Model DiscountIndividual
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TDiscountIndividual
 * 
 * @property int $id
 * @property int $ship_id
 * @property string $setting_month
 * @property string $type
 * @property string $currency
 * @property float $amount_discount
 * @property string $notice
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class TDiscountIndividual extends Eloquent
{
    protected $table = 't_discount_individual';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'ship_id' => 'int',
        'amount_discount' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'ship_id',
        'setting_month',
        'type',
        'currency',
        'amount_discount',
        'notice',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
