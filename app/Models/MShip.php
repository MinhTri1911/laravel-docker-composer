<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MShip
 * 
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property string $imo_number
 * @property string $mmsi_number
 * @property int $nation_id
 * @property int $classification_id
 * @property string $register_number
 * @property int $type_id
 * @property int $width
 * @property int $height
 * @property int $water_draft
 * @property int $total_weight_ton
 * @property int $total_ton
 * @property int $member_number
 * @property string $url_1
 * @property string $url_2
 * @property string $url_3
 * @property string $remark
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MShip extends Eloquent
{
    protected $table = 'm_ship';

    protected $casts = [
        'company_id' => 'int',
        'nation_id' => 'int',
        'classification_id' => 'int',
        'type_id' => 'int',
        'width' => 'int',
        'height' => 'int',
        'water_draft' => 'int',
        'total_weight_ton' => 'int',
        'total_ton' => 'int',
        'member_number' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name',
        'company_id',
        'imo_number',
        'mmsi_number',
        'nation_id',
        'classification_id',
        'register_number',
        'type_id',
        'width',
        'height',
        'water_draft',
        'total_weight_ton',
        'total_ton',
        'member_number',
        'url_1',
        'url_2',
        'url_3',
        'remark',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
