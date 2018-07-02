<?php

/**
 * Model UserLogin
 * 
 * @author QuangPM.
 * @date 2018/05/11.
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\SoftDeletes\SoftDeleteCustoms;

/**
 * Class TUserLogin
 * 
 * @property int $id
 * @property string $operation_person
 * @property int $ope_company_id
 * @property string $department
 * @property string $position
 * @property string $job
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class TUserLogin extends Authenticatable
{
    use Notifiable, SoftDeleteCustoms;

    protected $table = 't_user_login';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'ope_company_id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'operation_person',
        'ope_company_id',
        'department',
        'position',
        'job',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
