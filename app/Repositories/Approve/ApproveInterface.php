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
}