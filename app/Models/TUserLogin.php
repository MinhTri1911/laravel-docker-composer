<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\SoftDeletes\SoftDeleteCustoms;

/**
 * Class TUserLogin
 * 
 * @property int $id
 * @property string $name
 * @property int $ope_company_id
 * @property string $department
 * @property string $position
 * @property bool $auth_create
 * @property bool $auth_approve
 * @property bool $auth_reference
 * @property bool $auth_admin
 * @property string $login_id
 * @property string $password
 * @property int $type
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
    use SoftDeleteCustoms;

    /**
     * Setting column in database is delete_at
     */
    const DELETED_AT = 'del_flag';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_user_login';

    /**
     * Provides a convenient method of converting attributes to common data types
     *
     * @var array
     */
    protected $casts = [
        'ope_company_id' => 'int',
        'auth_create' => 'bool',
        'auth_approve' => 'bool',
        'auth_reference' => 'bool',
        'auth_admin' => 'bool',
        'type' => 'int',
        'del_flag' => 'bool'
    ];

    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ope_company_id',
        'department',
        'position',
        'auth_create',
        'auth_approve',
        'auth_reference',
        'auth_operation',
        'auth_admin',
        'login_id',
        'password',
        'type',
        'del_flag',
        'created_by',
        'updated_by'
    ];

    /**
     * Overrides the method to ignore the remember token
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }
}
