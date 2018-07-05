<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 04 Jul 2018 03:46:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MBillingMethod
 * 
 * @property int $id
 * @property string $name_jp
 * @property string $name_en
 * @property string $month_billing
 * @property int $month
 * @property int $unit
 * @property int $method
 * @property int $currency_id
 * @property float $charge
 * @property string $link_template
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MBillingMethod extends Eloquent
{
    protected $table = 'm_billing_method';

    protected $casts = [
        'month' => 'int',
        'unit' => 'int',
        'method' => 'int',
        'currency_id' => 'int',
        'charge' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name_jp',
        'name_en',
        'month_billing',
        'month',
        'unit',
        'method',
        'currency_id',
        'charge',
        'link_template',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
