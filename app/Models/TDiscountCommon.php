<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 04 Jul 2018 03:46:32 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TDiscountCommon
 * 
 * @property int $id
 * @property int $company_id
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
class TDiscountCommon extends Eloquent
{
    protected $table = 't_discount_common';

    protected $casts = [
        'company_id' => 'int',
        'currency_id' => 'int',
        'money_discount' => 'float',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'setting_month'
    ];

    protected $fillable = [
        'company_id',
        'setting_month',
        'currency_id',
        'money_discount',
        'remark',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
