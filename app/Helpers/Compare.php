<?php

namespace App\Helper;

class Compare
{
    public static function validate($date1, $date2)
    {

    }

    /**
     *
     */
    public static function replaceStr($str)
    {
        return str_replace('/', '-', $str);
    }
}
