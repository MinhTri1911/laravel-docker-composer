<?php
return [
    // Common
    'lbl_id_contract' => '利用契約ID',
    'lbl_version' => '改定番号',
    'lbl_ship' => '船舶' ,
    'lbl_currency' => '使用通貨',
    'lbl_service' => 'サービス',
    'lbl_start' => '契約開始年月日',
    'lbl_end' => '契約終了年月日',
    'header_spot' => 'スポット費用',
    'lbl_type_spot' => '課金種別',
    'lbl_cost_spot' => '請求金額',
    'lbl_remarks' => '備考',
    'lbl_spot_data' => 'データ作成費',
    'lbl_spot_regist' => '初期登録費',
    
    'btn_back' => '戻る',
    'btn_create' => ' 作成',
    'btn_update' => '更新',

    'btn_pop_search' => '検索',
    'btn_pop_cancel' => 'キャンセル',
    'btn_pop_ok' => 'OK',

    'header_pop_service' => 'サービスマスター検索',
    'lbl_pop_service_id' => 'サービスID',
    'lbl_pop_service_name' => 'サービス名',

    'header_pop_ship' => '船舶検索',
    'lbl_pop_ship_id' => '船舶ID ',
    'lbl_pop_ship_name' => '船名',

    // Own
    'create' => [
        'header' => 'サービス利用契約の個別追加',
        
    ], 
    'edit' => [
        'header' => 'サービス利用契約の個別編集',
    ],

    'restore' => [
        'header' => 'サービス利用契約復活',
    ],
    
    'error' => [
        'E003' => ':itemを入力してください。',
        'E004' => ':item は:value文字以内で入力してください。',
        'E005' => ':itemのフォーマットはYYYY/MM/dd形式にしてください。',
        'E020' => ':itemは:value以上で入力してください。',
        'E006' => ':startDateは:startEndより大きくしてください。',
        'E008' => ':valueは数字で入力してください。',
        'E016' => ':itemは形式が正しくありません。',
        'E012' => '契約終了日は契約開始日より大きくしてください。',
        'E007' => ':itemは:monthyearのみで選択してください。',
        'E019' => ':itemは:value以下で入力してください。',
        'service_not_exist' => 'サービスは存在しません。',
        
        'spot_gt_zero'      => '「:item」は0より大きくしてください。',
        'spot_is_number'    => '「:item」は数字で入力してください。',
        'spot_max_length'   => '「:item」は22文字以内で入力してください。',
    ],
];

