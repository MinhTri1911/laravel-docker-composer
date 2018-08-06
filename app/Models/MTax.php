<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MTax
 * 
 * @property int $id
 * @property float $rate
 * @property string $remark
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MTax extends Eloquent
{
    protected $table = 'm_tax';

    protected $casts = [
        'rate' => 'float'
    ];

    protected $fillable = [
        'rate',
        'remark',
        'created_by',
        'updated_by'
    ];
}
