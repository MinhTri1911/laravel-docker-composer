<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MShipType
 * 
 * @property int $id
 * @property string $code
 * @property string $type
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MShipType extends Eloquent
{
    protected $table = 'm_ship_type';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'code',
        'type',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
