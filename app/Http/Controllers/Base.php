<?php

/**
 * Register static
 *
 * @author Rikkei.QuyenL
 * @date 2018/07/19
 */

namespace App\Http\Controllers;

/**
 * Class Base
 * Authentication object
 */
class Base
{
    private static $_role;

    /**
     * Authentication role object
     */
    public static function role()
    {
        if (!self::$_role) {
            self::$_role = new Role();
        }

        return self::$_role;
    }
}
