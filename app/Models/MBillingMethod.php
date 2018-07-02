<?php

/**
 * Model BillingMethod
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MBillingMethod
 * 
 * @property int $id
 * @property string $name
 * @property string $month
 * @property string $total
 * @property string $charge
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
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name',
        'month',
        'total',
        'charge',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
