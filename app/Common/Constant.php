<?php

namespace App\Common;

class Constant{
    
    // Status delete is activating
    const DELETE_FLAG_FALSE = 0;
    
    // Status delete was deleted
    const DELETE_FLAG_TRUE = 1;
    
    // Status approve actived
    const APPROVED_DONE = 1;
    // Status approve pending to approve
    const APPROVED_PENDING = 2;
    // Status approve was rejected
    const APPROVED_REJECT = 3;
    
    // Status contract activating
    const CONTRACT_STATUS_ACTIVE = 0;
    // Status contract pending
    const CONTRACT_STATUS_PENDING = 1;
    // Status contract finished/deleted
    const CONTRACT_STATUS_FINISH = 2;

    // Constant status contract
    const STATUS_CONTRACT_ACTIVE    = 0;
    const STATUS_CONTRACT_PENDING   = 1;
    const STATUS_CONTRACT_EXPIRED   = 2;

    // Constant approve
    const STATUS_APPROVED          = 1;
    const STATUS_WAITING_APPROVE   = 2;
    const STATUS_REJECT_APPROVE    = 3;

    // Constant ID Type Charge 
    const CHARGE_SERVICE_ID    = 0;
    const CHARGE_SPOT_ID       = 1;
    const CHARGE_DISCOUNT_ID   = 2;

    // Constant ID Detail Type Charge 
    const DETAIL_CHARGE_VOLUME_DISCOUNT      = 0;
    const DETAIL_CHARGE_DISCOUNT_COMMON      = 1;
    const DETAIL_CHARGE_DISCOUNT_INDIVIDUAL  = 2;
}