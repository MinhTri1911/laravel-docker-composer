<?php

/**
 * Model Contract
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MContract
 * 
 * @property int $id
 * @property string $revision_number
 * @property int $company_id
 * @property int $ship_id
 * @property int $system_id
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property bool $del_flag
 * @property bool $status
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
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'company_id' => 'int',
        'ship_id' => 'int',
        'system_id' => 'int',
        'del_flag' => 'bool',
        'status' => 'bool'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    protected $fillable = [
        'revision_number',
        'company_id',
        'ship_id',
        'system_id',
        'start_date',
        'end_date',
        'del_flag',
        'status',
        'created_by',
        'updated_by'
    ];
}
