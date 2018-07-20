<?php

return [
    '404' => [
        'title' => '404:Not Found',
        'description_page_not_found' => '404 ページが見つかりません。',
        'btn_back_home' => 'ホームページ',
    ],
    '500' => [
        'title' => '500:Internal Server Error',
        'description_internal_server_error' => 'CGIもしくはSSIが正しく動作していません。',
        'btn_back_home' => 'ホームページ',
    ],
    '403' => [
        'title' => '403:Forbidden',
        'description_permission_denied' => '指定されたページまたはファイルへのアクセスが禁止されています。',
        'btn_back_home' => 'ホームページ',
    ],

    'notfound' => [
        'title' => 'Not Found',
        'description_notfound' => 'データが見つかりませんでした。',
    ],

    '401' => [
        'title_error' => '401:Authorized',
        'content_error' => '認証情報が無化のため、あくせくが拒否されました。',
    ],

    'e001_not_found_infomation' => 'データが見つかりませんでした。',
    'e003_required' => ':fieldを入力してください。',
    'e005_format_date' => ':fieldのフォーマットは:format形式にしてください。',
    'e008_numeric' => ':fieldは数字で入力してください。',
    'e009_not_exists_master' => ':fieldは存在しません。',
    'e012_start_date_less_than_end_date' => '契約終了日は契約開始日より大きくしてください。',
    'e022_password_not_match' => 'パスワードが間違っています。',
    'e020_greater_than_or_equal' => ':fieldは<現在日付>より大きくしてください。',
    'w005_have_contract_watting_approve' => '契約削除できません。承認待ちの契約が存在します。',
];
