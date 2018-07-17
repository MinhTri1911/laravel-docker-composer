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
      3 =>  "拒絶",
    ];

    // Contract status text
    const CONTRACT_O = [
      0 =>  "有効",
      1 =>  "中断",
      2 =>  "完了",
    ];

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
        'd' => 'Y/m/d',
        'dt' => 'Y/m/d H:i:s',
        't' => 'H:i:s'
    ];
}
