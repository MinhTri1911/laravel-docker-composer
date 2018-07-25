<?php

/**
 * ClassificationRepository.php
 *
 * Hanlde eloquent query builder ship type
 *
 * @package    App\Repositories\Classification
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\Classification;

use App\Models\MShipClassification;
use App\Common\Constant;
use App\Repositories\EloquentRepository;

class ClassificationRepository extends EloquentRepository implements ClassificationInterface
{
    public function getModel()
    {
        return MShipClassification::class;
    }

    /**
     * Function get all classification
     * @param array columns
     * @return Collection
     */
    public function getAllShipClassification($columns = ['*'])
    {
        // Get all classification with del_flag is false
        return $this->where('del_flag', Constant::DELETE_FLAG_FALSE)->get($columns);
    }

    /**
     * Function check classification id exists
     *
     * @param int $id
     * @return boolean
     */
    public function checkClassificationExists($id)
    {
        return $this->where('id', $id)->where('del_flag', Constant::DELETE_FLAG_FALSE)->exists();
    }
}
