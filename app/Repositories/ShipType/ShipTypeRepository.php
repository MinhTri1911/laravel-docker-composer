<?php

/**
 * ShipTypeRepository.php
 *
 * Hanlde eloquent query builder ship type
 *
 * @package    App\Repositories\ShipType
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\ShipType;

use App\Models\MShipType;
use App\Common\Constant;
use App\Repositories\EloquentRepository;

class ShipTypeRepository extends EloquentRepository implements ShipTypeInterface
{
    public function getModel()
    {
        return MShipType::class;
    }

    /**
     * Function get all ship type
     * @param array columns
     * @return Collection
     */
    public function getAllShipType($columns = ['*'])
    {
        // Get all ship type with del_flag is false
        return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
    }

    /**
     * Function check ship type exists
     *
     * @param int $typeId
     * @return boolean
     */
    public function checkTypeExists($typeId)
    {
        return $this->where('id', $typeId)->where('del_flag', Constant::DELETE_FLAG_FALSE)->exists();
    }
}
