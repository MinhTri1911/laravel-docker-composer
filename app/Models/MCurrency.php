<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MCurrency
 * 
 * @property int $id
 * @property string $code
 * @property string $name_jp
 * @property string $name_en
 * @property float $rate
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MCurrency extends Eloquent
{
    protected $table = 'm_currency';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'rate' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'code',
        'name_jp',
        'name_en',
        'rate',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
