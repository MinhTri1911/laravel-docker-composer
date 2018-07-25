<?php

namespace App\Traits;

trait CommonArray 
{
    /**
     * Function check all element in keys is exists in arr
     * Return true when all element in keys is in arr
     * @param array $keys
     * @param array $arr
     * @return boolean
     */
    public function checkArrayExists($keys, $arr)
    {
        return !array_diff($keys, $arr);
    }
}
