<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MCompanyOperation
 * 
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $nation_id
 * @property string $address
 * @property bool $language
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MCompanyOperation extends Eloquent
{
    protected $table = 'm_company_operation';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'nation_id' => 'int',
        'language' => 'bool',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name',
        'short_name',
        'nation_id',
        'address',
        'language',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
