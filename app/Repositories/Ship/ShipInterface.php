<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\Ship
 * @author Rikkei.quyenl
 * @date 2018/07/05
 */

namespace App\Repositories\Ship;

interface ShipInterface
{
    /**
     * Get detail ship by id
     *
     * @access public
     * @param int $idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function getShip($idShip = null);

    /**
     * Get contract of ship
     *
     * @access public
     * @param int $idShip
     * @param int|array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContract($idShip = null, $idContract = '');

    /**
     * Get contract activating of ship
     *
     * @access public
     * @param int $idShip
     * @param array $idContract
     * @return mixed Illuminate\Support\Collection
     */
    public function getContractActive($idShip = null, $idContract = []);

    /**
     * Get spot of ship by id ship
     *
     * @access public
     * @param int $idShip
     * @param int $idSpot
     * @param null $limit
     * @return mixed Illuminate\Support\Collection
     */
    public function getSpot($idShip = null, $idSpot = null, $limit = null);

    /**
     * Function get common list ship query
     *
     * @param int $companyId default null
     * @return mixed Illuminate\Support\Collection
     */
    public function getCommonListShipQuery($companyId = null);

    /**
     * Function make condition for search company
     *
     * @param array $param filter keyword conditions
     * @return mixed Illuminate\Support\Collection
     */
    public function conditionSearchShip($param);

 /**
     * Function get list ship by companyId
     * @access public
     * @param int companyId
     * @return mixed
     */
    public function getListShip($companyId);
    
    /**
     * Function search list ship
     * @access public
     * @param int currencyId
     * @param int shipId
     * @param int shipName
     * @return mixed
    */
    public function searchListShip($companyId, $shipId , $shipName);
    
     /**
     * Get detail ship by id
     *
     * @access public
     * @param int $idShip
     * @return mixed Illuminate\Support\Collection
     */
    public function getIdShip($idShip = null);
}
