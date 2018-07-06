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
}