<?php

/**
 * Model Ship
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MShip
 * 
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property bool $language
 * @property string $imo_number
 * @property string $mmsi_number
 * @property string $nationality
 * @property string $classification
 * @property string $classification_control_number
 * @property bool $type
 * @property string $specification
 * @property string $url_1
 * @property string $url_2
 * @property string $url_3
 * @property bool $del_flag
 * @property bool $status
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
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'company_id' => 'int',
        'language' => 'bool',
        'type' => 'bool',
        'del_flag' => 'bool',
        'status' => 'bool'
    ];

    protected $fillable = [
        'name',
        'company_id',
        'language',
        'imo_number',
        'mmsi_number',
        'nationality',
        'classification',
        'classification_control_number',
        'type',
        'specification',
        'url_1',
        'url_2',
        'url_3',
        'del_flag',
        'status',
        'created_by',
        'updated_by'
    ];
}
