<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 02 Jul 2018 07:56:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MCompany
 * 
 * @property int $id
 * @property string $name_jp
 * @property string $name_en
 * @property int $nation_id
 * @property string $postal_code
 * @property string $head_office_address
 * @property string $represent_person
 * @property float $fund
 * @property int $employees_number
 * @property string $year_research
 * @property int $billing_method_id
 * @property string $month_billng
 * @property int $payment_deadline_no
 * @property int $billing_day_no
 * @property string $currency_code
 * @property int $currency_id
 * @property string $ope_person_name_1
 * @property string $ope_position_1
 * @property string $ope_department_1
 * @property string $ope_postal_code_1
 * @property string $ope_address_1
 * @property string $ope_phone_1
 * @property string $ope_fax_1
 * @property string $ope_email_1
 * @property string $ope_person_name_2
 * @property string $ope_position_2
 * @property string $ope_department_2
 * @property string $ope_postal_code_2
 * @property string $ope_address_2
 * @property string $ope_phone_2
 * @property string $ope_fax_2
 * @property string $ope_email_2
 * @property int $ope_company_id
 * @property string $url
 * @property bool $del_flag
 * @property string $created_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $updated_by
 *
 * @package App\Models
 */
class MCompany extends Eloquent
{
    protected $table = 'm_company';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'nation_id' => 'int',
        'fund' => 'float',
        'employees_number' => 'int',
        'billing_method_id' => 'int',
        'payment_deadline_no' => 'int',
        'billing_day_no' => 'int',
        'currency_id' => 'int',
        'ope_company_id' => 'int',
        'del_flag' => 'bool'
    ];

    protected $fillable = [
        'name_jp',
        'name_en',
        'nation_id',
        'postal_code',
        'head_office_address',
        'represent_person',
        'fund',
        'employees_number',
        'year_research',
        'billing_method_id',
        'month_billng',
        'payment_deadline_no',
        'billing_day_no',
        'currency_code',
        'currency_id',
        'ope_person_name_1',
        'ope_position_1',
        'ope_department_1',
        'ope_postal_code_1',
        'ope_address_1',
        'ope_phone_1',
        'ope_fax_1',
        'ope_email_1',
        'ope_person_name_2',
        'ope_position_2',
        'ope_department_2',
        'ope_postal_code_2',
        'ope_address_2',
        'ope_phone_2',
        'ope_fax_2',
        'ope_email_2',
        'ope_company_id',
        'url',
        'del_flag',
        'created_by',
        'updated_by'
    ];
}
