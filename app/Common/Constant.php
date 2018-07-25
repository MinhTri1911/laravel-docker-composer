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

    // Array billing paper status
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

    // Status of billing method
    const BILLING_METHOD_MAIL = 0;
    const BILLING_METHOD_PRINT_SEAL = 1;
    const BILLING_METHOD_PRINT_NORMAL = 2;

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
    
    // Code status not found data
    const HTTP_CODE_ERROR_NF = "NotFound";

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

    // Allow access screen identification
    const ALLOW_CONTRACT_CREATE = 1;
    const ALLOW_CONTRACT_EDIT = 2;
    const ALLOW_CONTRACT_DELETE = 3;
    const ALLOW_CONTRACT_VIEW = 4;
    const ALLOW_CONTRACT_CREATE_EDIT = 5;
    const ALLOW_CONTRACT_FULL = 6;
    const ALLOW_CONTRACT_APPROVE = 7;
    const ALLOW_COMPANY_CREATE = 8;
    const ALLOW_COMPANY_EDIT = 9;
    const ALLOW_COMPANY_DELETE = 10;
    const ALLOW_COMPANY_VIEW = 11;
    const ALLOW_COMPANY_FULL = 12;
    const ALLOW_BILLING_CREATE = 13;
    const ALLOW_BILLING_EDIT = 14;
    const ALLOW_BILLING_DELETE = 15;
    const ALLOW_BILLING_VIEW = 16;
    const ALLOW_BILLING_CREATE_EDIT = 17;
    const ALLOW_BILLING_FULL = 18;
    const ALLOW_BILLING_APPROVE = 19;
    const ALLOW_SHIP_CREATE = 20;
    const ALLOW_SHIP_EDIT = 21;
    const ALLOW_SHIP_DELETE = 22;
    const ALLOW_SHIP_VIEW = 23;
    const ALLOW_SHIP_CREATE_EDIT = 24;
    const ALLOW_SHIP_FULL = 25;
    const ALLOW_SPOT_APPROVE = 26;
    const ALLOW_ROLE_SCREEN = 27;

    // Screens of create role
    const ROLE_CREATE_OPERATION_SCREEN = [
        // Contract
        Constant::ALLOW_CONTRACT_CREATE,
        Constant::ALLOW_CONTRACT_EDIT,
        Constant::ALLOW_CONTRACT_DELETE,
        Constant::ALLOW_CONTRACT_VIEW,
        Constant::ALLOW_CONTRACT_CREATE_EDIT,
        Constant::ALLOW_CONTRACT_FULL,
        // Company
        Constant::ALLOW_COMPANY_CREATE,
        Constant::ALLOW_COMPANY_EDIT,
        Constant::ALLOW_COMPANY_DELETE,
        Constant::ALLOW_COMPANY_VIEW,
        Constant::ALLOW_COMPANY_FULL,
        // Billing
        Constant::ALLOW_BILLING_CREATE,
        Constant::ALLOW_BILLING_EDIT,
        Constant::ALLOW_BILLING_DELETE,
        Constant::ALLOW_BILLING_VIEW,
        Constant::ALLOW_BILLING_CREATE_EDIT,
        Constant::ALLOW_BILLING_FULL,
        // Ship
        Constant::ALLOW_SHIP_CREATE,
        Constant::ALLOW_SHIP_EDIT,
        Constant::ALLOW_SHIP_DELETE,
        Constant::ALLOW_SHIP_VIEW,
        Constant::ALLOW_SHIP_CREATE_EDIT,
        Constant::ALLOW_SHIP_FULL,
    ];

    // Screens of approve role
    const ROLE_APPROVE_SCREEN = [
        Constant::ALLOW_BILLING_CREATE,
        Constant::ALLOW_BILLING_EDIT,
        Constant::ALLOW_BILLING_DELETE,
        Constant::ALLOW_BILLING_VIEW,
        Constant::ALLOW_BILLING_CREATE_EDIT,
        Constant::ALLOW_CONTRACT_APPROVE,
        Constant::ALLOW_BILLING_APPROVE,
        Constant::ALLOW_SPOT_APPROVE,
    ];

    // Screens of reference role
    const ROLE_REFERENCE_SCREEN = [
        Constant::ALLOW_CONTRACT_VIEW,
        Constant::ALLOW_COMPANY_VIEW,
        Constant::ALLOW_BILLING_VIEW,
        Constant::ALLOW_SHIP_VIEW
    ];

    /**
     * Status depend company
     * 0. Not depend (IN)
     * 1. Depend (OUT)
     */
    const STATUS_DEPEND_COMPANY_IN = 1;
    const STATUS_DEPEND_COMPANY_OUT = 0;

    // Check button permission
    const IS_CHECK_SCREEN = 0;
    const IS_CHECK_BUTTON = 1;
}
