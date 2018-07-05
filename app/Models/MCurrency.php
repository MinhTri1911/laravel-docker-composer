<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 04 Jul 2018 03:46:31 +0000.
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

    protected $casts = [
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
