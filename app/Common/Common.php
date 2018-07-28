<?php

/**
 * Configure logging common
 *
 * @package App\Common
 * @author Rikkei.Quangpm
 * @date 2018/06/19
*/

namespace App\Common;


/**
 * Configure logging common
 */
class Common
{
    public static function foramtNumber($value)
    {
        $value = str_replace(',', '', $value);
        $value = str_replace('.00', '', $value);
        
        return $value;
    }
}
