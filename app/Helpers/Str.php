<?php

/**
 * App\Helpers\Str.php
 *
 * Create helpers handle string to output
 *
 * @package    Helper
 * @author     Rikkei.DungLV
 * @date       2018/07/03
 */

namespace App\Helpers;

class Str
{
    /**
     * Check valid string is date and month of input greater than month of now
     * 
     * @access public
     * @param date|string $date [Date input with format Y/m/d]
     * @return boolean
     */
    public static function checkValidMonthFromStr($date = "Y-m-d")
    {
        // Export string to array
        $dateCheck = explode('-', $date);
        if($dateCheck[0] > date('Y'))
            return true;
        elseif($dateCheck[0] == date('Y') && $dateCheck[1] >= date('m'))
           return true;
        else
            return false;
    }
}
