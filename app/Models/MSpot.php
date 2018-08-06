<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MSpot
 * 
 * @property int $id
 * @property string $name_jp
 * @property string $name_en
 * @property int $currency_id
 * @property int $type
 * @property float $charge
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MSpot extends Eloquent
{
    protected $table = 'm_spot';

    protected $casts = [
        'currency_id' => 'int',
        'type' => 'int',
        'charge' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name_jp',
        'name_en',
        'currency_id',
        'type',
        'charge',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
