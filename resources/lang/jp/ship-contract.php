<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'detail' => [
        'title_ship_contract' => '船舶管理',
        'header_ship_contract' => '船舶管理',
        'header_ship_info' => '船舶情報',
        'lbl_ship_id' => '船舶ID',
        'lbl_ship_name' => '船名',
        'lbl_company' => '会社名',
        'lbl_imo' => 'IMO番号',
        'lbl_mmsi' => 'MMSI番号',
        'lbl_nation' => '船籍',
        'lbl_ship_level' => '船級',
        'lbl_ship_code' => '船級登録番号',
        'lbl_ship_type' => '船種',
        'lbl_ship_wide' => '幅',
        'lbl_ship_long' => '全長',
        'lbl_ship_mon' => '満載喫水',
        'lbl_ship_quan' => '総トン',
        'lbl_ship_weight' => '載貨重量トン',
        'lbl_ship_teu' => 'TEU･車両･乗客等数',
        'lbl_ship_note' => '備考',
        'lbl_ship_url1' => '関連情報URL1',
        'lbl_ship_url2' => '関連情報URL2',
        'lbl_ship_url3' => '関連情報URL3',

        'btn_edit_ship' => '編集',

        'lbl_ship_contract' => '契約',
        'lbl_no_ship_contract' => '合計:number件',
        'lbl_contract_id' => '契約ID',
        'lbl_contract_version' => '改定番号',
        'lbl_contract_service' => 'サービス',
        'lbl_contract_start' => '契約開始年月日',
        'lbl_contract_end' => '契約終了年月日',
        'lbl_contract_status' => '状態',
        'lbl_contract_approve' => '承認',
        'lbl_contract_date_create' => '作成日',
        'lbl_contract_date_update' => '更新日',

        'btn_contract_create' => '作成',
        'btn_contract_disable' => '中断',
        'btn_contract_delete' => '削除',
        'btn_contract_edit' => '編集',
        'btn_contract_restore' => 'Restore',

        'lbl_ship_spot' => 'スポット費用',
        'lbl_no_ship_spot' => '合計:number件',
        'lbl_spot_id' => 'スポットID',
        'lbl_spot_name' => '課金種別',
        'lbl_spot_setting' => '発生年月',
        'lbl_spot_cost' => '請求金額（円）',
        'lbl_spot_approve' => '承認',
        'lbl_spot_date_create' => '作成日',
        'lbl_spot_date_update' => '更新日',
        'lbl_limit' => '表示件数',
       
        'btn_back' => '戻る',
        'btn_create' => '作成',
        'btn_disable' => '中断',
        'btn_delete' => '削除',
        'btn_edit' => '編集',
        'btn_contract_restore' => '復活',
        'btn_cancel' => 'キャンセル',
        'btn_ok' => 'OK',
        
        'res_tit_restore_contract' => '契約復活確認',
        'msg_restore_success' => '契約が有効化されました。',
        'msg_restore_failed' => 'Restore khoong thnhaf công',
        
        'res_tit_disable_contract' => '契約無効化確認',
        'msg_disable_success' => ':contractの契約が無効にされました。',
        'msg_disable_failed' => 'Disable không thành công',
        
        'res_tit_delete_contract' => '契約削除確認',
        'msg_delete_success' => ':contractの契約が削除されました。',
        'msg_delete_failed' => 'Delete không thành công',
        
        'res_tit_delete_spot' => 'スポット費用削除確認',
        'msg_delete_spot_success' => 'スポット費用が削除されました。',
        'msg_delete_spot_failed' => 'Delete không thành công spot',
        
        'res_tit_delete_ship' => '船舶削除確認ポップアップ',
        'msg_delete_ship_success' => 'Delete thành công ship :ship',
        'msg_delete_ship_failed' => 'Delete ship không thành công',
        'msg_delete_ship_failed_auth' => '認証エラーが発生しました。',
        
        'pop_auth_delete_ship' => '船舶削除確認ポップアップ',
        'lbl_input_pw' => 'パスワード入力',

        'lbl_popup_del_contract' => '契約を削除確認',
        'lbl_popup_del_contract_msg' => '選択した契約を削除してもよろしいですか?',
        
        'pop_title_contract_del' => '契約を削除確認',
        'pop_message_contract_del' => '選択した契約を削除してもよろしいですか?',
        'pop_title_contract_error' => 'エラー',
        'pop_message_contract_unselect' => '契約を選択してください。',
        
        'pop_title_contract_re' => "契約を復活確認",
        'pop_message_contract_re' => "の契約を復活してもよろしいですか?",
        
        'pop_title_contract_dis' => "船舶削除確認ポップアップ",
        'pop_message_contract_dis' => "船舶を承認してもよろしいですか?",
        
        'pop_title_spot_del' => "スポット費用を削除確認",
        'pop_message_spot_del' => "を削除してもよろしいですか?",
        
        'pop_title_ship_del' => "船舶削除確認ポップアップ",
        'pop_message_ship_del' => "船舶を承認してもよろしいですか?",
        
        'pop_message_auth_pw' => "パスワードを入力してください。",
        
        'pop_title_reject' => '却下理由'
    ]
];
