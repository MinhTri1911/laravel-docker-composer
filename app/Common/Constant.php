<?php

namespace App\Common;

class Constant
{
    // Status delete is activating
    const DELETE_FLAG_FALSE     = 0;
    // Status delete was deleted
    const DELETE_FLAG_TRUE      = 1;

    // Status no create bill
    const BILLED_FLAG_FALSE     = 0;
    // Status billed
    const BILLED_FLAG_TRUE      = 1;

    // Status no delivery
    const DELIVERY_FLAG_FALSE     = 0;
    // Status delivered
    const DELIVERY_FLAG_TRUE      = 1;

    // Approved status text
    const APPROVED_O = [
      1 =>  "承認済",
      2 =>  "承認待ち",
      3 =>  "却下",
    ];

    // Contract status text
    const CONTRACT_O = [
      0 =>  "有効",
      1 =>  "中断",
      2 =>  "完了",
      3 =>  "完了"
    ];

    // Arrray billing paper status
    const ARR_BILLING_PAPER_STATUS = [
        1 => '未作成',
        2 => '発行待ち',
        3 => '発行済'
    ];

    // Status billing paper don't create
    const STATUS_BILLING_NO_CREATE    = 1;
    // Status billing paper waiting delivery
    const STATUS_BILLING_WAITING_DELIVERY    = 2;
    // Status billing paper delivered
    const STATUS_BILLING_DELIVERED    = 3;

    // Status contract activating
    const STATUS_CONTRACT_ACTIVE    = 0;
    // Status contract pending
    const STATUS_CONTRACT_PENDING   = 1;
    // Status contract finished
    const STATUS_CONTRACT_EXPIRED   = 2;
    // Status contract deleted
    const STATUS_CONTRACT_DELETED   = 3;

    // Status approve actived
    const STATUS_APPROVED          = 1;
    // Status approve pending to approve
    const STATUS_WAITING_APPROVE   = 2;
    // Status approve was rejected
    const STATUS_REJECT_APPROVE    = 3;

    // Constant ID Type Charge
    const CHARGE_SERVICE_ID    = 0;
    const CHARGE_SPOT_ID       = 1;
    const CHARGE_DISCOUNT_ID   = 2;

    // Constant ID Detail Type Charge
    const DETAIL_CHARGE_VOLUME_DISCOUNT      = 0;
    const DETAIL_CHARGE_DISCOUNT_COMMON      = 1;
    const DETAIL_CHARGE_DISCOUNT_INDIVIDUAL  = 2;

    // Default total record per page
    const PAGINATION_PER_PAGE = 10;

    // Filter total record per page
    const ARY_PAGINATION_PER_PAGE = [
        10 => 10,
        25 => 25,
        50 => 50
    ];

    // Status code OK
    const HTTP_CODE_SUCCESS = 200;

    // Status code error 403 Forbidden
    const HTTP_CODE_ERROR_403 = 403;

    // Status code error 404 Not Found
    const HTTP_CODE_ERROR_404 = 404;

    // Status code error 500 Internal Server Error
    const HTTP_CODE_ERROR_500 = 500;

    // Format datetime
    const FORMAT_DATE_TIME = [
        'd'     => 'Y/m/d',
        'dt'    => 'Y/m/d H:i:s',
        't'     => 'H:i:s',
        'ym'     => 'Y/m'
    ];
    
    // Config type approve are contract, spot, billing
    const TYPE_APPROVE = ['契約', 'スポット費用', '請求書'];
    
    // Config type operation
    const TYPE_OPE = [
        'create'    => '作成',
        'edit'      => '修正',
        'delete'    => '削除',
        'reactive'    => 'REACTIVE',
        'restore'    => 'RESTORE'
    ];
    
    const ID_SCREEN = [
        // FCM0001
        'SCM0001' => 'SCM0001',
        'SCM0002' => 'SCM0002',
        'SCM0003' => 'SCM0003',
        // FMA0001
        'SMA0001' => 'SMA0001',
        'SMA0002' => 'SMA0002',
        'SMA0003' => 'SMA0003',
        // FMB0001
        'SMB0001' => 'SMB0001',
        'SMB0002' => 'SMB0002',
        'SMB0003' => 'SMB0003',
        'SMB0004' => 'SMB0004',
        'SMB0005' => 'SMB0005',
        'SMB0006' => 'SMB0006',
        'SMB0007' => 'SMB0007',
        'SMB0008' => 'SMB0008',
        'SMB0009' => 'SMB0009',
        // FMC0001
        'SMC0001' => 'SMC0001',
        'SMC0002' => 'SMC0002',
        'SMC0003' => 'SMC0003',
        'SMC0004' => 'SMC0004',
        // FBA0001
        'SBA0001' => 'SBA0001',
        'SBA0002' => 'SBA0002',
        'SBA0003' => 'SBA0003',
        'SBA0004' => 'SBA0004',
        'BBA0005' => 'BBA0005',
    ];
}
