<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
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
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'currency_id' => 'int',
        'charge' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name_jp',
        'name_en',
        'currency_id',
        'charge',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
