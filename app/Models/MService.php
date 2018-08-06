<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MService
 * 
 * @property int $id
 * @property string $name_jp
 * @property string $name_en
 * @property string $name_short
 * @property float $version_max
 * @property float $version_min
 * @property float $version_rev
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MService extends Eloquent
{
    protected $table = 'm_service';

    protected $casts = [
        'version_max' => 'float',
        'version_min' => 'float',
        'version_rev' => 'float',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name_jp',
        'name_en',
        'name_short',
        'version_max',
        'version_min',
        'version_rev',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
