<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TDiscountIndividual
 * 
 * @property int $id
 * @property int $contract_id
 * @property \Carbon\Carbon $setting_month
 * @property int $currency_id
 * @property float $money_discount
 * @property string $remark
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
        'contract_id' => 'int',
        'currency_id' => 'int',
        'money_discount' => 'float',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'setting_month'
    ];

    protected $fillable = [
        'contract_id',
        'setting_month',
        'currency_id',
        'money_discount',
        'remark',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
