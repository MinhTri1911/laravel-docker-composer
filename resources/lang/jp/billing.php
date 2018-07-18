<?php
return [
    /**
     * Language Japan For Common
     */
    'title_create_billing_paper'     => '請求書発行',
    'title_history_billing' => '請求履歴管理',
    'title_statistic_billing' => '請求集計',
    'title_popup_update_payment_date' => '入金確認日更新ポップアップ',
    'title_popup_reason_reject' => '却下理由',

    // Header
    'head_search' => '検索',

    // Label
    'lbl_company_name' => '会社名',
    'lbl_payment_due_date' => '入金予定日',
    'lbl_status' => '状態',
    'lbl_ope_person_name_1' => '窓口1 担当者名',
    'lbl_ope_phone_1' => '窓口1 電話番号',
    'lbl_ope_email_1' => '窓口1 Eメール',
    'lbl_ope_person_name_2' => '窓口2 担当者名',
    'lbl_ope_phone_2' => '窓口2 電話番号',
    'lbl_ope_email_2' => '窓口2 Eメール',
    'lbl_remark' => '備考',
    'lbl_is_detail' => '請求明細',
    'lbl_count_record_1' => '合計',
    'lbl_count_record_2' => '件',
    'lbl_number_record_display' => '表示件数',
    'lbl_history_billing_id' => '請求書ID',
    'lbl_company_id' => '会社ID',
    'lbl_nation_name' => '国名',
    'lbl_currency_name' => '使用通貨',
    'lbl_create_paper_date' => '請求年月日',
    'lbl_payment_deadline_date' => '支払期限',
    'lbl_payment_actual_date' => '入金確認日',
    'lbl_total_money' => '総請求額',
    'lbl_status_approve' => '承認',
    'lbl_year' => '年',
    'lbl_month' => '月',

//    History billing
    'lbl_object_statistic' => '対象',
    'lbl_statistic_year' => '年',
    'lbl_statistic_many_year' => '集計',
    'lbl_half_before_year' => '上半期',
    'lbl_half_after_year' => '下半期',
    'lbl_quarter_1' => '第１四半期',
    'lbl_quarter_2' => '第２四半期',
    'lbl_quarter_3' => '第３四半期',
    'lbl_quarter_4' => '第４四半期',
    'lbl_detail' => '詳細',
    'lbl_title_chart' => 'チャートで集計',

//    PDF
    'lbl_company_address' => '本社住所',
    'lbl_represent_person' => '代表者',
    'lbl_ope_position_1' => '窓口1 役職',
    'lbl_ope_address_1' => '窓口1 住所',
    'lbl_ope_company_name' => '所管会社',
    'lbl_ope_company_short_name' => '略称',
    'lbl_ope_address' => '住所',
    'lbl_title_detail' => '利用･課金明細',

    // Header table list comnpany
    'tbl_list_company_header' => [
        'no' => 'No',
        'company_name' => '会社名',
        'payment_due_date' => '入金予定日',
        'billing_method_name' => '支払方法',
        'operation_no' => '窓口1',
        'ope_name' => '担当者名',
        'ope_phone' => '電話番号',
        'ope_email' => 'メールアドレス',
        'total_money' => '請求総額<br>（円）',
        'status' => '状態',
        'status_approve' => '承認',
        'reason' => '却下理由',
    ],

    // Header table history billing
    'tbl_history_header' => [
        'history_billing_id' => '請求書ID',
        'company_name' => '会社名',
        'nation_name' => '国名',
        'create_paper_date' => '請求年月日',
        'payment_deadline_date' => '支払期限',
        'payment_actual_date' => '入金確認日',
        'total_money' => '総請求額',
        'link_pdf' => 'PDF原本リンク',
        'status_approve' => '承認',
        
    ],

    // Header table statistic billing
    'tbl_statistic_header' => [
        'service_name' => 'サービス',
        'month' => '月',
    ],

    // Button
    'btn_search' => '検索',
    'btn_back' => '戻る',
    'btn_cancel' => 'キャンセル',
    'btn_update' => '更新',
    'btn_create' => '作成',
    'btn_export_csv' => 'CSV形式で出力',
    'btn_delivery' => '発行',
    'btn_statistic' => '表示',
    'btn_output_csv' => 'CSV出力',
    'btn_print' => '印刷',
    'btn_Ok' => 'Ok',
];