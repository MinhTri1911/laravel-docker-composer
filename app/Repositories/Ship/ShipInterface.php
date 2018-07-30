<?php

/**
 * Ship management Interface
 *
 * @package App\Repositories\Ship
 * @author Rikkei.QuyenL
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
     * Handle Update contract base on ID and Data update
     * 
     * @access public
     * @param int|array $id
     * @param array $data
     */
    public function updateContract($id, $data);
    
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

    /**
     * Function get ship by company id
     * @param int companyId
     * @param array columns
     * @return array
     */
    public function getShipByCompanyId($companyId, $columns);

    /**
     * Function delete ships by ids
     * @param array ids
     * @param array data
     * @return boolean
     */
    public function updateDeleteShipWattingApprove($ids, $data);

    /**
     * Function select ship not have service by company id and service id
     * @param int companyId
     * @param int serviceId
     * @param array columnsSelect
     * @return array
     */
    public function selectShipNotHaveService($companyId, $serviceId, $columnsSelect = ['*']);

    /**
     * Get operation company
     *
     * @access public
     * @return array
     */
    public function getListCompany();

    /**
     * Check exist company id
     *
     * @param int $companyId
     * @return bool
     */
    public function checkExistCompany($companyId);

    /**
     * Get list nation
     *
     * @access public
     * @return array
     */
    public function getListNation();

    /**
     * Check exist nation id
     *
     * @param int $nationId
     * @return bool
     */
    public function checkExistNation($nationId);

    /**
     * Get list classification
     *
     * @access public
     * @return array
     */
    public function getListClassification();

    /**
     * Check exist classification id
     *
     * @param int $classificationId
     * @return bool
     */
    public function checkExistClassification($classificationId);

    /**
     * Get ship type
     *
     * @access public
     * @return array
     */
    public function getListShipType();

    /**
     * Check exist ship type id
     *
     * @param int $shipTypeId
     * @return bool
     */
    public function checkExistShipType($shipTypeId);

    /**
     * Insert ship to database
     *
     * @param array $data
     * @return bool
     */
    public function createShip($data);

    /**
     * Check exist ship name
     *
     * @param string $name
     * @return bool
     */
    public function checkExistShipName($name);

    /**
     * Check exist ship ImoNumber
     *
     * @param string $imoNumber
     * @return bool
     */
    public function checkExistShipImoNumber($imoNumber);

    /**
     * Get edit ship data by id
     *
     * @param int $shipId
     * @return array
     */
    public function getEditShipData($shipId);

    /**
     * Update ship to database
     *
     * @param int $shipId
     * @param array $data
     * @return bool
     */
    public function updateShip($shipId, $data);
}
