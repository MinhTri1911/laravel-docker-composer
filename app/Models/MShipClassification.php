<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MShipClassification
 * 
 * @property int $id
 * @property string $code
 * @property string $name_jp
 * @property string $name_en
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MShipClassification extends Eloquent
{
    protected $table = 'm_ship_classification';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'code',
        'name_jp',
        'name_en',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
