<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:16 +0000.
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
 * @property int $tax_id
 * @property int $status
 * @property int $approved_flag
 * @property \Carbon\Carbon $start_pending_date
 * @property \Carbon\Carbon $end_pending_date
 * @property string $reason_reject
 * @property bool $del_flag
 * @property string $remark
 * @property string $deleted_at
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MContract extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'm_contract';

    protected $casts = [
        'revision_number' => 'float',
        'ship_id' => 'int',
        'service_id' => 'int',
        'currency_id' => 'int',
        'tax_id' => 'int',
        'status' => 'int',
        'approved_flag' => 'int',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'start_pending_date',
        'end_pending_date'
    ];

    protected $fillable = [
        'revision_number',
        'ship_id',
        'service_id',
        'currency_id',
        'start_date',
        'end_date',
        'tax_id',
        'status',
        'approved_flag',
        'start_pending_date',
        'end_pending_date',
        'reason_reject',
        'del_flag',
        'remark',
        'created_by',
        'updated_by'
    ];
}
