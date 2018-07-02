<?php

/**
 * Model VolumeDiscount
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TVolumeDiscount
 * 
 * @property int $id
 * @property string $amount_threshold
 * @property float $rate
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class TVolumeDiscount extends Eloquent
{
    protected $table = 't_volume_discount';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'rate' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'amount_threshold',
        'rate',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
