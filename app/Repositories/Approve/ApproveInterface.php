<?php

/**
 * Approve interface
 *
 * @package App\Repositories\Approve
 * @author Rikkei.DungLV
 * @date 2018/07/11
 */

namespace App\Repositories\Approve;

interface ApproveInterface
{
    /**
     * Get list contract with condition
     * 
     * @access public
     * @param array $paramCondition
     * @return Illuminate\Support\Collection
     */
    public function getListContract($paramCondition);
    
    /**
     * Get list spot with condition
     * 
     * @access public
     * @param array $paramCondition
     * @return Illuminate\Support\Collection
     */
    public function getListSpot($paramCondition);
    
    /**
     * Get list billing with condition
     * 
     * @access public
     * @param array $paramCondition
     * @return Illuminate\Support\Collection
     */
    public function getListBilling($paramCondition);
    
    /**
     * Execute query update data contract
     * 
     * @access public
     * @param int|array $id
     * @return int
     */
    public function updateContract($id, $dataUpdate);
    
    /**
     * Execute query update data spot
     * 
     * @access public
     * @param int|array $id
     * @return int
     */
    public function updateSpot($id, $dataUpdate);

    /**
     * Handle delete spot out from system
     * @access public
     * @param array $arrIdSpot
     * @return boolean Illuminate\Database\Query\Builder::delete()
     */
    public function deleteSpotApproval($arrIdSpot = []);

    /**
     * Execute query update data billing
     * 
     * @access public
     * @param int|array $id
     * @return int
     */
    public function updateBilling($id = '', $dataUpdate = []);
}
