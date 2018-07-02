<?php

/**
 * Model System
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MSystem
 * 
 * @property int $id
 * @property string $name
 * @property string $version
 * @property bool $language
 * @property string $currency
 * @property float $usage_monthly_fee
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MSystem extends Eloquent
{
    protected $table = 'm_system';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'language' => 'bool',
        'usage_monthly_fee' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name',
        'version',
        'language',
        'currency',
        'usage_monthly_fee',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
