<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 04 Jul 2018 03:46:31 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MContract
 *
 * @property int $id
 * @property float $revision_number
 * @property int $ship_id
 * @property int $service_id
 * @property int $currency_id
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property int $status
 * @property int $approved_flag
 * @property string $reason_reject
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MContract extends Eloquent
{
    protected $table = 'm_contract';

    protected $casts = [
        'revision_number' => 'float',
        'ship_id' => 'int',
        'service_id' => 'int',
        'currency_id' => 'int',
        'status' => 'int',
        'approved_flag' => 'int'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    protected $fillable = [
        'revision_number',
        'ship_id',
        'service_id',
        'currency_id',
        'start_date',
        'end_date',
        'status',
        'remark',
        'approved_flag',
        'reason_reject',
        'created_by',
        'updated_by',
        'updated_at',
        'pending_at',
        'deleted_at',
    ];
}
