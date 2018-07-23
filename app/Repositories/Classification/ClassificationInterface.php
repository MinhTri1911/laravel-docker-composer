<?php

/**
 * ClassificationInterface.php
 *
 * Define function must be implement
 *
 * @package    App\Repositories\Classification
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\Classification;

interface ClassificationInterface
{
    /**
     * Function get all classification
     * @param array columns
     * @return Collection
     */
    public function getAllShipClassification($columns = ['*']);
}
