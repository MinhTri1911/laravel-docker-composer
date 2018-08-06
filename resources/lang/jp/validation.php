<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => ':attribute は数字で入力してください。 また、:max 半角文字以下で入力してください。',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute を正しいメールアドレス形式で入力してください。',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute は整数で入力してください。',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute は :max 以下で入力してください。 ',
        'file'    => ':attribute は :max 文字以内で入力してください。 ',
        'string'  => ':attribute は :max 文字以内で入力してください。 ',
        'array'   => ':attribute は :max 文字以内で入力してください。 ',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute:min以上で入力してください。',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => ':attribute は数字で入力してください。',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute は形式が正しくありません。',
    'required'             => ':attribute を入力してください。',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute は不正なurl形式になってしまいます。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'condition.*.number_basal'=>[
//                'integer'   => '基礎報酬値は整数値を入力して下さい。',
                'required'  => '基礎報酬値を入力して下さい。',
//                'min'       => '基礎報酬値は10000以内にして下さい。',
//                'max'       => '基礎報酬値は10000以内にして下さい。',
        ],
        'new_condition.*.number_basal'=>[
//                'integer'   => '基礎報酬値は整数値を入力して下さい。',
                'required'  => '基礎報酬値を入力して下さい。',
//                'min'       => '基礎報酬値は10000以内にして下さい。',
//                'max'       => '基礎報酬値は10000以内にして下さい。',
        ],
        'group_coefficient.*.value'=>[
//                'integer'   => 'ポイント係数は整数値を入力して下さい。',
                'required'  => 'ポイント係数を入力して下さい。',
//                'min'       => 'ポイントは10以内で入力して下さい。',
//                'max'       => 'ポイントは10以内で入力して下さい。',
        ],
        'new_group_coefficient.*.value'=>[
//                'integer'   => 'ポイント係数は整数値を入力して下さい。',
                'required'  => 'ポイント係数を入力して下さい。',
//                'min'       => 'ポイントは10以内で入力して下さい。',
//                'max'       => 'ポイントは10以内で入力して下さい。',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        // Login attributes
        'login_id' => __('auth.lbl_login_id'),
        'password' => __('auth.lbl_password'),

        // Detail company, popup add service for all ship
        'service-id' => __('company.lbl_service_name'),
        'start-date' => __('company.lbl_contract_start_date'),
        'end-date' => __('company.lbl_contract_end_date'),

        // Create ship
        'txt-ship-name' => __('ship.lbl_title_ship_name'),
        'slb-company' => __('ship.lbl_title_company'),
        'txt-imo-number' => __('ship.lbl_title_imo_number'),
        'txt-mmsi-number' => __('ship.lbl_title_mmsi_number'),
        'nation-id' => __('ship.lbl_title_nation'),
        'slb-classification' => __('ship.lbl_title_classification'),
        'txt-register-number' => __('ship.lbl_title_register_number'),
        'slb-ship-type' => __('ship.lbl_title_ship_type'),
        'txt-ship-length' => __('ship.lbl_title_ship_length'),
        'txt-ship-width' => __('ship.lbl_title_ship_width'),
        'txt-water-draft' => __('ship.lbl_title_water_draft'),
        'txt-total-weight-ton' => __('ship.lbl_title_total_weight_ton'),
        'txt-weight-ton' => __('ship.lbl_title_weight_ton'),
        'txt-member-number' => __('ship.lbl_title_member_number'),
        'txt-remark' => __('ship.lbl_title_remark'),
        'txt-url-1' => __('ship.lbl_url_1'),
        'txt-url-2' => __('ship.lbl_url_2'),
        'txt-url-3' => __('ship.lbl_url_3'),


        // Create Company
        'txt-company-name-jp' => trans('company.lbl_title_company_name_jp'),
        'txt-company-name-en' => trans('company.lbl_title_company_name_en'),
        'company-nation-id' => trans('company.lbl_title_company_nation'),
        'txt-company-postal-code' => trans('company.lbl_title_company_postal_code'),
        'txt-company-address' => trans('company.lbl_title_company_address'),
        'txt-company-represent-person' => trans('company.lbl_title_company_represent_person'),
        'txt-company-fund' => trans('company.lbl_title_company_fund'),
        'company-currency-id' => trans('company.lbl_title_company_currency'),
        'txt-company-employee-number' => trans('company.lbl_title_company_employee_number'),
        'txt-company-year-research' => trans('company.lbl_title_company_year_research'),
        'slb-company-billing-method' => trans('company.lbl_title_company_billing_method'),
        // 'slb-company-month-billing.*' => trans('company.lbl_title_company_month_billing'),
        'txt-company-payment-deadline-no' => trans('company.lbl_title_company_payment_deadline_no'),
        'txt-company-site' => trans('company.lbl_title_company_site'),
        'txt-company-currency-code' => trans('company.lbl_title_company_currency_code'),
        'slb-company-operation' => trans('company.lbl_title_company_operation'),
        'txt-company-url' => trans('company.lbl_title_company_url'),
        'txt-ope-name-1' => trans('company.ope_1') . trans('company.lbl_title_ope_name'),
        'txt-ope-position-1' => trans('company.ope_1') . trans('company.lbl_title_ope_position'),
        'txt-ope-department-1' => trans('company.ope_1') . trans('company.lbl_title_ope_department'),
        'txt-ope-postal-code-1' => trans('company.ope_1') . trans('company.lbl_title_ope_postal_code'),
        'txt-ope-address-1' => trans('company.ope_1') . trans('company.lbl_title_ope_address'),
        'txt-ope-phone-1' => trans('company.ope_1') . trans('company.lbl_title_ope_phone'),
        'txt-ope-fax-1' => trans('company.ope_1') . trans('company.lbl_title_ope_fax'),
        'txt-ope-email-1' => trans('company.ope_1') . trans('company.lbl_title_ope_email'),
        'txt-ope-name-2' => trans('company.ope_2') . trans('company.lbl_title_ope_name'),
        'txt-ope-position-2' => trans('company.ope_2') . trans('company.lbl_title_ope_position'),
        'txt-ope-department-2' => trans('company.ope_2') . trans('company.lbl_title_ope_department'),
        'txt-ope-postal-code-2' => trans('company.ope_2') . trans('company.lbl_title_ope_postal_code'),
        'txt-ope-address-2' => trans('company.ope_2') . trans('company.lbl_title_ope_address'),
        'txt-ope-phone-2' => trans('company.ope_2') . trans('company.lbl_title_ope_phone'),
        'txt-ope-fax-2' => trans('company.ope_2') . trans('company.lbl_title_ope_fax'),
        'txt-ope-email-2' => trans('company.ope_2') . trans('company.lbl_title_ope_email'),
        'txt-ship-name' => trans('ship.lbl_title_ship_name'),
        'txt-ship-imo-number' => trans('ship.lbl_title_imo_number'),
        'ship-nation-id' => trans('ship.lbl_title_nation'),
        'slb-ship-classification' => trans('ship.lbl_title_classification'),
        'slb-ship-type' => trans('ship.lbl_title_ship_type'),
    ],

];
