<?php

/**
 * ShipTypeInterface.php
 *
 * Define function must be implement
 *
 * @package    App\Repositories\ShipType
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\ShipType;

interface ShipTypeInterface
{
    /**
     * Function get all ship type
     * @param array columns
     * @return Collection
     */
    public function getAllShipType($columns = ['*']);
}
