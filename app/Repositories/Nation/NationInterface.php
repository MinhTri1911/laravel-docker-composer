<?php

/**
 * NationInterface.php
 *
 * Define function must be implement
 *
 * @package    App\Repositories\Nation
 * @author     Rikkei.Trihnm
 * @date       2018/07/23
 */

namespace App\Repositories\Nation;

interface NationInterface
{
    /**
     * Function get all nation
     * @param array columns
     * @return Collection
     */
    public function getAllNation($columns = ['*']);

    /**
     * Function get nation by id or name
     * @param int id
     * @param string name
     * @param array columns
     * @return Collection
     */
    public function getNationByIdOrName($id = 0, $name = '', $columns = ['*']);

    /**
     * Function check exists nation id
     *
     * @param int $nationId
     * @return boolean
     */
    public function checkExists($nationId);
}
