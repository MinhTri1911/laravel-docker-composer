<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Aug 2018 04:29:17 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class THistoryContract
 * 
 * @property int $id
 * @property int $contract_id
 * @property float $revision_number
 * @property int $ship_id
 * @property int $service_id
 * @property int $currency_id
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
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
 * @property string $updated_by
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $create_data_at
 *
 * @package App\Models
 */
class THistoryContract extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 't_history_contract';

    protected $casts = [
        'contract_id' => 'int',
        'revision_number' => 'float',
        'ship_id' => 'int',
        'service_id' => 'int',
        'currency_id' => 'int',
        'status' => 'int',
        'approved_flag' => 'int',
        'del_flag' => 'bool'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'start_pending_date',
        'end_pending_date',
        'create_data_at'
    ];

    protected $fillable = [
        'contract_id',
        'revision_number',
        'ship_id',
        'service_id',
        'currency_id',
        'start_date',
        'end_date',
        'status',
        'approved_flag',
        'start_pending_date',
        'end_pending_date',
        'reason_reject',
        'del_flag',
        'remark',
        'created_by',
        'updated_by',
        'create_data_at'
    ];
}
