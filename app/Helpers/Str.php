<?php

namespace App\Helpers;

class Str{
    public static function checkValidMonthFromStr($date = "Y-m-d"){
        $dateCheck = explode('-', $date);
        if($dateCheck[0] > date('Y'))
            return true;
        elseif($dateCheck[0] == date('Y') && $dateCheck[1] >= date('m'))
           return true;
        else
            return false;
    }
}
